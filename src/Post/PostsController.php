<?php

namespace App\Post;

use App\Core\AbstractController;

class PostsController extends AbstractController
{
    public function __construct(PostsRepository $postsRepository, CommentsRepository $commentsRepository)
    {
        $this->postsRepository = $postsRepository;
        $this->commentsRepository = $commentsRepository;
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