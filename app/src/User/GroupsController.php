<?php

namespace App\User;

use App\Core\AbstractController;

class GroupsController extends AbstractController
{
    public function __construct(GroupsRepository $groupsRepository, UsersRepository $usersRepository, AuthService $authService)
    {
        $this->groupsRepository = $groupsRepository;
        $this->usersRepository = $usersRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        if (!empty($_POST['name']) AND !empty($_POST['users'])) {
            $name = $_POST['name'];
            $users = $_POST['users'];
            $this->groupsRepository->insert($name, $users);
            $savedSuccess = true;
        }
        $this->render("user/group/admin/add", [
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function admin_index()
    {
        $this->authService->checkAccess();
        $groups = $this->groupsRepository->findAll();
        rsort($groups);
        $this->render("user/group/admin/index", ['groups' => $groups]);
    }

    public function delete()
    {
        if (!$this->authService->checkAccess()) {
            die();
        } else {
            $id = $_GET['id'];
            $group = $this->groupsRepository->findID($id);
            if (!empty($group)) {
                $this->groupsRepository->delete($id);
            }
            $this->admin_index();
        }
    }

    public function edit()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        $id = $_GET['id'];
        $entry = $this->groupsRepository->findID($id);
        if (!empty($_POST['name']) AND !empty($_POST['users'])) {
            $entry->name = $_POST['name'];
            $entry->users = $_POST['users'];
            $this->groupsRepository->update($entry);
            $savedSuccess = true;
        }
        $this->render("user/group/admin/edit", [
            'entry' => $entry,
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function index()
    {
        $groups = $this->groupsRepository->findAll();
        rsort($groups);
        $this->render("user/group/index", ['groups' => $groups]);
    }

    public function show()
    {
        $id = $_GET['id'];
        // Code for adding Users by id(?)

        $group = $this->groupsRepository->findID($id);
        $users = $this->usersRepository->fetchAllByID($id);
        $this->render("user/group/show", [
            'group' => $group,
            'users' => $users
        ]);
    }
}
