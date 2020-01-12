<?php

namespace App\User;

use App\Core\AbstractController;

class GroupsController extends AbstractController
{
    public function __construct(GroupsRepository $groupsRepository, GroupmetasRepository $groupmetasRepository, UsersRepository $usersRepository, AuthService $authService)
    {
        $this->groupsRepository = $groupsRepository;
        $this->groupmetasRepository = $groupmetasRepository;
        $this->usersRepository = $usersRepository;
        $this->authService = $authService;
    }

    public function add()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $this->groupsRepository->insert($name);
            $savedSuccess = true;
        }
        $this->render("user/group/admin/add", [
            'savedSuccess' => $savedSuccess
        ]);
    }

    public function addUsernameByGroupId($username, $group_id)
    {
        $this->authService->checkAccess();
        $user_id = $this->usersRepository->findUsername($username)->id;
        $this->groupmetasRepository->insert($user_id, $group_id);
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

    public function deleteUsernameByGroupId()
    {
        if (!$this->authService->checkAccess()) {
            die();
        } else {
            $user_id = $this->usersRepository->findUsername($_GET['username'])->id;
            $group_id = $_GET['from'];
            $this->authService->checkAccess();
            $this->groupmetasRepository->remove($user_id, $group_id);
        }
    }

    public function edit()
    {
        $this->authService->checkAccess();
        $savedSuccess = false;
        $id = $_GET['id'];
        $entry = $this->groupsRepository->findID($id);
        if (!empty($_POST['name'])) {
            $entry->name = $_POST['name'];
            $this->groupsRepository->update($entry);
            $savedSuccess = true;
        }
        if (!empty($_POST['username'])) {
            $this->addUsernameByGroupId($_POST['username'], $id);
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
