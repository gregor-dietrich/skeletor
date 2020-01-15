<?php

namespace App\Post;

use App\Core\AbstractController;
use App\User\AuthService;
use App\User\UsersRepository;

class PostsController extends AbstractController
{
    public function __construct(PostsRepository $postsRepository, CategoriesRepository $categoriesRepository, UsersRepository $usersRepository, CommentsRepository $commentsRepository, AuthService $authService)
    {
        $this->postsRepository = $postsRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->usersRepository = $usersRepository;
        $this->commentsRepository = $commentsRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->check();
        $categories = $this->categoriesRepository->findAll();
        $savedSuccess = false;
        if (!empty($_POST['title']) AND !empty($_POST['content']) AND !empty($_POST['user_id']) AND $this->usersRepository->findUsername($_SESSION['login'])->id == $_POST['user_id']) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $user_id = $_POST['user_id'];
            if (!empty($_POST['category_id'])) {
                $category_id = $_POST['category_id'];
            } else {
                $category_id = NULL;
            }
            $this->postsRepository->insert($title, $content, $user_id, $category_id);
            $savedSuccess = true;
        }
        $this->render("post/admin/add", [
            'categories' => $categories,
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function delete()
    {
        if (!$this->authService->check()) {
            die();
        } else {
            $id = $_GET['id'];
            $post = $this->postsRepository->findID($id);
            if (!empty($post)) {
                $this->postsRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function admin_index()
    {
        $this->authService->check();
        $posts = $this->postsRepository->findAll();
        rsort($posts);
        $this->render("post/admin/index", ['posts' => $posts]);
    }

    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->postsRepository->findID($id);
        $categories = $this->categoriesRepository->findAll();
        $savedSuccess = false;
        if (!empty($_POST['title']) AND !empty($_POST['content'])) {
            $entry->title = $_POST['title'];
            $entry->content = $_POST['content'];
            if (!empty($_POST['category_id'])) {
                $entry->category_id = $_POST['category_id'];
            } else {
                $entry->category_id = NULL;
            }
            $entry->last_edit = datetime_now();
            $this->postsRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("post/admin/edit", [
            'entry' => $entry,
            'categories' => $categories,
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function index()
    {
        $posts = $this->postsRepository->findAll();
        rsort($posts);
        $this->render("post/index", ['posts' => $posts]);
    }

    public function show()
    {
        $id = $_GET['id'];
        if ((isset($_POST['content']) and isset($_POST['user_id'])) and ($this->usersRepository->findUsername($_SESSION['login'])->id == $_POST['user_id'])) {
            $content = $_POST['content'];
            $user_id = $_POST['user_id'];
            $this->commentsRepository->addByID($id, $content, $user_id);
        }
        $post = $this->postsRepository->findID($id);
        $comments = $this->commentsRepository->fetchAllByID($id);
        $this->render("post/show", [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
