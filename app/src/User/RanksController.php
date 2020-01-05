<?php

namespace App\User;

use App\Core\AbstractController;

class RanksController extends AbstractController
{
    private $permissions = [
        "post_add", "post_delete", "post_edit", "post_category_add", "post_category_delete",
        "post_category_edit", "post_comment_add", "post_comment_delete", "post_comment_edit", "user_add",
        "user_delete", "user_edit", "user_rank_add", "user_rank_delete", "user_rank_edit"
    ];

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
            foreach ($this->permissions AS $permission) {
                if (!empty($_POST[$permission])) {
                    $$permission = $_POST[$permission];
                } else {
                    $$permission = 0;
                }
            }
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
            foreach ($this->permissions AS $permission) {
                if (!empty($_POST[$permission])) {
                    $entry->$permission = $_POST[$permission];
                } else {
                    $entry->$permission = 0;
                }
            }
            $this->ranksRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("user/rank/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }
}