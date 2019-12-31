<?php

namespace App\Post;

use App\Core\AbstractController;
use App\User\AuthService;

class PostsController extends AbstractController
{
    public function __construct(PostsRepository $postsRepository, CommentsRepository $commentsRepository, AuthService $authService)
    {
        $this->postsRepository = $postsRepository;
        $this->commentsRepository = $commentsRepository;
        $this->authService = $authService;
    }
    public function add()
    {
        $this->authService->check();
        $savedSuccess = false;
        if (!empty($_POST['title']) AND !empty($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $this->postsRepository->insert($title, $content);
            $savedSuccess = true;
        }
        $this->render("post/admin/add", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }
    public function admin_index()
    {
        $this->authService->check();
        $posts = $this->postsRepository->findAll();
        $this->render("post/admin/index", ['posts' => $posts]);
    }
    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->postsRepository->findID($id);
        $savedSuccess = false;
        if (!empty($_POST['title']) AND !empty($_POST['content'])) {
            $entry->title = $_POST['title'];
            $entry->content = $_POST['content'];
            $this->postsRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("post/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }
    public function index()
    {
        $posts = $this->postsRepository->findAll();
        $this->render("post/index", ['posts' => $posts]);
    }
    public function show()
    {
        $id = $_GET['id'];
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            $this->commentsRepository->addByID($id, $content);
        }
        $post = $this->postsRepository->findID($id);
        $comments = $this->commentsRepository->fetchAllByID($id);
        $this->render("post/show", [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}

?>