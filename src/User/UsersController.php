<?php

namespace App\User;

use App\Core\AbstractController;
use App\User\AuthService;

class UsersController extends AbstractController
{
    public function __construct(UsersRepository $usersRepository, AuthService $authService)
    {
        $this->usersRepository = $usersRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->check();
        $savedSuccess = false;
        $error = null;
        if (!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm'])) {
            if ($_POST['password'] == $_POST['password_confirm']) {
                require __DIR__ . "/../System/salt.php";
                $username = $_POST['username'];
                $salt = bin2hex(random_bytes(10));
                $password = password_hash($salt . $_POST['password'] . $_ENV['salt'], PASSWORD_DEFAULT);
                $this->usersRepository->insert($username, $password, $salt);
                $savedSuccess = true;
            } else {
                $error = "Passwords don't match! User not saved!";
            }
        }
        $this->render("user/admin/add", [
            'savedSuccess' => $savedSuccess,
            'error' => $error
        ]);
    }

    public function admin_index()
    {
        $this->authService->check();
        $users = $this->usersRepository->findAll();
        $this->render("user/admin/index", ['users' => $users]);
    }

    public function delete()
    {
        if (!$this->authService->check()) {
            die();
        } else {
            $id = $_GET['id'];
            $user = $this->usersRepository->findID($id);
            if (!empty($user)) {
                $this->usersRepository->delete($id);
            }
            $users = $this->usersRepository->findAll();
            $this->render("user/admin/index", ['users' => $users]);
        }
    }

    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->usersRepository->findID($id);
        $savedSuccess = false;
        $error = null;
        if (!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm'])) {
            if ($_POST['password'] == $_POST['password_confirm']) {
                require __DIR__ . "/../System/salt.php";
                $entry->username = $_POST['username'];
                $salt = bin2hex(random_bytes(10));
                $entry->password = password_hash($salt . $_POST['password'] . $_ENV['salt'], PASSWORD_DEFAULT);
                $entry->salt = $salt;
                $this->usersRepository->update($entry);
                $savedSuccess = true;
            } else {
                $error = "Passwords don't match! User not saved!";
            }
        }
        $this->render("user/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess,
            'error' => $error
        ]);
    }

}
