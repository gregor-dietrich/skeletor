<?php

namespace App\User;

use App\Core\AbstractController;

class LoginController extends AbstractController
{
    public function __construct(UsersRepository $usersRepository, AuthService $authService)
    {
        $this->usersRepository = $usersRepository;
        $this->authService = $authService;
    }

    public function dashboard()
    {
        $this->authService->check();
        $this->render("user/dashboard", []);
    }

    public function login()
    {
        if (isset($_SESSION['login'])) {
            header("Location: ucp");
            return;
        }

        $error = false;
        if (!empty($_POST['username']) AND !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->authService->attempt($username, $password)) {
                header("Location: ucp");
                return;
            } else {
                $error = "Username not found or incorrect password.";
            }

        }
        $this->render("user/login", [
            'error' => $error
        ]);
    }

    public function logout()
    {
        $this->authService->logout();
        header("Location: login");
    }
}
