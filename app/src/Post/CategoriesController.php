<?php

namespace App\Post;

use App\Core\AbstractController;
use App\User\AuthService;

class CategoriesController extends AbstractController
{

    public function __construct(CategoriesRepository $categoriesRepository, PostsRepository $postsRepository, AuthService $authService)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->postsRepository = $postsRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->check();
        $savedSuccess = false;
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            if (!empty($_POST['parent_id'])) {
                $parent_id = $_POST['parent_id'];
            } else {
                $parent_id = NULL;
            }
            $this->categoriesRepository->insert($name, $parent_id);
            $savedSuccess = true;
        }
        $categories = $this->categoriesRepository->findAll();
        $this->render("post/category/admin/add", [
            'savedSuccess' => $savedSuccess,
            'categories' => $categories
        ]);
    }

    public function delete()
    {
        if (!$this->authService->check()) {
            die();
        } else {
            $id = $_GET['id'];
            $user = $this->categoriesRepository->findID($id);
            if (!empty($user)) {
                $this->categoriesRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function admin_index()
    {
        $this->authService->check();
        $categories = $this->categoriesRepository->fetchAllOrdered();
        $this->render("post/category/admin/index", ['categories' => $categories]);
    }

    public function edit()
    {
        $this->authService->check();
        $id = $_GET['id'];
        $entry = $this->categoriesRepository->findID($id);
        $savedSuccess = false;
        if (!empty($_POST['name'])) {
            $entry->name = $_POST['name'];
            if (!empty($_POST['parent_id'])) {
                $entry->parent_id = $_POST['parent_id'];
            } else {
                $entry->parent_id = NULL;
            }
            $this->categoriesRepository->update($entry);
            $savedSuccess = true;
        }
        $categories = $this->categoriesRepository->findAll();
        $this->render("post/category/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess,
            'categories' => $categories
        ]);
    }

    public function index()
    {
        $categories = $this->categoriesRepository->fetchAllOrdered();
        $this->render("post/category/index", ['categories' => $categories]);
    }

    public function show()
    {
        $id = $_GET['id'];
        $category = $this->categoriesRepository->findID($id);
        $children = $this->categoriesRepository->fetchAllByParentID($id);
        $posts = $this->postsRepository->fetchAllByCategoryID($id);
        $this->render("post/category/show", [
            'category' => $category,
            'children' => $children,
            'posts' => $posts
        ]);
    }
}
