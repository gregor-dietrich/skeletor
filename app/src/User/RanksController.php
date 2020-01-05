<?php

namespace App\User;

use App\Core\AbstractController;

class RanksController extends AbstractController
{
    public function __construct(RanksRepository $ranksRepository, AuthService $authService)
    {
        $this->ranksRepository = $ranksRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->check();
        $savedSuccess = false;
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $post_add = $_POST['post_add'];
            $post_delete = $_POST['post_delete'];
            $post_edit = $_POST['post_edit'];
            $post_category_add = $_POST['post_category_add'];
            $post_category_delete = $_POST['post_category_delete'];
            $post_category_edit = $_POST['post_category_edit'];
            $post_comment_add = $_POST['post_comment_add'];
            $post_comment_delete = $_POST['post_comment_delete'];
            $post_comment_edit = $_POST['post_comment_edit'];
            $user_add = $_POST['user_add'];
            $user_delete = $_POST['user_delete'];
            $user_edit = $_POST['user_edit'];
            $user_rank_add = $_POST['user_rank_add'];
            $user_rank_delete = $_POST['user_rank_delete'];
            $user_rank_edit = $_POST['user_rank_edit'];
            $this->ranksRepository->insert($name, $post_add, $post_delete, $post_edit, $post_category_add, $post_category_delete, $post_category_edit, $post_comment_add, $post_comment_delete, $post_comment_edit, $user_add, $user_delete, $user_edit, $user_rank_add, $user_rank_delete, $user_rank_edit);
            $savedSuccess = true;
        }
        $this->render("user/rank/admin/add", [
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function delete()
    {
        if (!$this->authService->check()) {
            die();
        } else {
            $id = $_GET['id'];
            $user = $this->ranksRepository->findID($id);
            if (!empty($user)) {
                $this->ranksRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function admin_index()
    {
        $this->authService->check();
        $ranks = $this->ranksRepository->findAll();
        rsort($ranks);
        $this->render("user/rank/admin/index", ['ranks' => $ranks]);
    }

    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->ranksRepository->findID($id);
        $savedSuccess = false;
        if (!empty($_POST['name'])) {
            $entry->name = $_POST['name'];
            $entry->post_add = $_POST['post_add'];
            $entry->post_delete = $_POST['post_delete'];
            $entry->post_edit = $_POST['post_edit'];
            $entry->post_category_add = $_POST['post_category_add'];
            $entry->post_category_delete = $_POST['post_category_delete'];
            $entry->post_category_edit = $_POST['post_category_edit'];
            $entry->post_comment_add = $_POST['post_comment_add'];
            $entry->post_comment_delete = $_POST['post_comment_delete'];
            $entry->post_comment_edit = $_POST['post_comment_edit'];
            $entry->user_add = $_POST['user_add'];
            $entry->user_delete = $_POST['user_delete'];
            $entry->user_edit = $_POST['user_edit'];
            $entry->user_rank_add = $_POST['user_rank_add'];
            $entry->user_rank_delete = $_POST['user_rank_delete'];
            $entry->user_rank_edit = $_POST['user_rank_edit'];
            $this->ranksRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("user/rank/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }
}