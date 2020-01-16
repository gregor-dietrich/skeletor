<?php

namespace App\User;

use App\Core\AbstractController;
use App\Post\PostsRepository;
use App\Post\CommentsRepository;

class UsersController extends AbstractController
{
    public function __construct(UsersRepository $usersRepository, GroupsRepository $groupsRepository, GroupmetasRepository $groupmetasRepository, RanksRepository $ranksRepository, PostsRepository $postsRepository, CommentsRepository $commentsRepository, AuthService $authService)
    {
        $this->usersRepository = $usersRepository;
        $this->groupsRepository = $groupsRepository;
        $this->groupmetasRepository = $groupmetasRepository;
        $this->ranksRepository = $ranksRepository;
        $this->postsRepository = $postsRepository;
        $this->commentsRepository = $commentsRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->check();
        $ranks = $this->ranksRepository->findAll();
        $savedSuccess = false;
        $error = null;
        if (!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm'])) {
            if ($_POST['password'] == $_POST['password_confirm']) {
                require __DIR__ . "/../System/salt.php";
                $username = $_POST['username'];
                $rank_id = $_POST['rank_id'];
                if (empty($_POST['email'])) {
                    $email = NULL;
                } else {
                    $email = $_POST['email'];
                }
                $salt = bin2hex(random_bytes(10));
                $password = password_hash($salt . $_POST['password'] . $_ENV['salt'], PASSWORD_DEFAULT);
                unset($_ENV['salt']);
                $this->usersRepository->insert($username, $password, $salt, $rank_id, $email);
                $savedSuccess = true;
            } else {
                $error = "Passwords don't match! User not saved!";
            }
        }
        $this->render("user/admin/add", [
            'ranks' => $ranks,
            'savedSuccess' => $savedSuccess,
            'error' => $error
        ]);
    }

    public function delete()
    {
        if (!$this->authService->check()) {
            die();
        } else {
            $id = $_GET['id'];
            $user = $this->usersRepository->findID($id);
            if (!empty($user) and $user->username != $_SESSION['login']) {
                $this->usersRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function admin_index()
    {
        $this->authService->check();
        $users = $this->usersRepository->findAll();
        rsort($users);
        $this->render("user/admin/index", ['users' => $users]);
    }

    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->usersRepository->findID($id);
        $savedSuccess = false;
        $error = null;
        $ranks = $this->ranksRepository->findAll();
        if (!empty($_POST['username'])) {
            $entry->username = $_POST['username'];
            $entry->rank_id = $_POST['rank_id'];
            if (empty($_POST['email'])) {
                $entry->email = NULL;
            } else {
                $entry->email = $_POST['email'];
            }
            if (!empty($_POST['password']) AND $_POST['password'] == $_POST['password_confirm']) {
                require __DIR__ . "/../System/salt.php";
                $salt = bin2hex(random_bytes(10));
                $entry->password = password_hash($salt . $_POST['password'] . $_ENV['salt'], PASSWORD_DEFAULT);
                unset($_ENV['salt']);
                $entry->salt = $salt;
            } elseif (!empty($_POST['password']) AND $_POST['password'] != $_POST['password_confirm']) {
                $error = "Passwords don't match! User not saved!";
            }
            $this->usersRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("user/admin/edit", [
            'entry' => $entry,
            'ranks' => $ranks,
            'savedSuccess' => $savedSuccess,
            'error' => $error
        ]);
    }

    public function show()
    {
        $id = $_GET['id'];
        $user = $this->usersRepository->findID($id);
        $posts = $this->postsRepository->fetchAllByUserID($id);
        rsort($posts);
        $comments = $this->commentsRepository->fetchAllByUserID($id);
        rsort($comments);
        $groups = $this->groupmetasRepository->fetchAllByUserID($id);
        rsort($groups);
        $this->render("user/show", [
            'user' => $user,
            'posts' => $posts,
            'comments' => $comments,
            'groups' => $groups
        ]);
    }

    public function edit_profile()
    {
        $this->authService->check();
        $entry = $this->usersRepository->findUsername($_SESSION['login']);
        if (!empty($_POST['username'])) {
            $entry->username = $_POST['username'];
            if (empty($_POST['email'])) {
                $entry->email = NULL;
            } else {
                $entry->email = $_POST['email'];
            }
            if (!empty($_POST['password']) AND $_POST['password'] == $_POST['password_confirm']) {
                require __DIR__ . "/../System/salt.php";
                $salt = bin2hex(random_bytes(10));
                $entry->password = password_hash($salt . $_POST['password'] . $_ENV['salt'], PASSWORD_DEFAULT);
                unset($_ENV['salt']);
                $entry->salt = $salt;
            } elseif (!empty($_POST['password']) AND $_POST['password'] != $_POST['password_confirm']) {
                $error = "Passwords don't match! User not saved!";
            }
            $this->usersRepository->update($entry);
        }
        $this->render("user/edit_profile", [
            'entry' => $entry
        ]);
    }

    public function ucp()
    {
        $this->authService->check();
        $entry = $this->usersRepository->findUsername($_SESSION['login']);
        $this->render("user/ucp", [
            'entry' => $entry
        ]);
    }
}
