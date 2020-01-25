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
                $user = $this->usersRepository->findUsername($username);
                if ($user->activated) { if (!$user->banned) {
                        $_SESSION['login'] = $user->username;
                        session_regenerate_id(true);
                        $user->last_ip = $_SERVER['REMOTE_ADDR'];
                        $user->last_login = datetime_now();
                        $this->usersRepository->update($user);
                        header("Location: ucp");
                        return;
                    } else { $error = "Your account has been suspended."; }
                } else { $error = "Account not activated. Check your inbox."; }
            } else { $error = "Username not found or incorrect password."; }
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
