<?php

namespace App\Page;

use App\Core\AbstractController;
use App\User\AuthService;

class PagesController extends AbstractController
{
    public function __construct(PagesRepository $pagesRepository, AuthService $authService)
    {
        $this->pagesRepository = $pagesRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        if (!empty($_POST['title']) AND !empty($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $this->pagesRepository->insert($title, $content);
            $savedSuccess = true;
        }
        $this->render("page/admin/add", [
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function delete()
    {
        if (!$this->authService->checkAccess()) {
            die();
        } else {
            $id = $_GET['id'];
            $page = $this->pagesRepository->findID($id);
            if (!empty($page)) {
                $this->pagesRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function admin_index()
    {
        $this->authService->checkAccess();
        $pages = $this->pagesRepository->findAll();
        rsort($pages);
        $this->render("page/admin/index", ['pages' => $pages]);
    }

    public function edit()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        $id = $_GET['id'];
        $entry = $this->pagesRepository->findID($id);
        if (!empty($_POST['title']) AND !empty($_POST['content'])) {
            $entry->title = $_POST['title'];
            $entry->content = $_POST['content'];
            $this->pagesRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("page/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function show()
    {
        $id = $_GET['id'];
        $page = $this->pagesRepository->findID($id);
        $this->render("page/show", [
            'page' => $page
        ]);
    }
}
