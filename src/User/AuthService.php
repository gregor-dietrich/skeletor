<?php

namespace App\User;

class AuthService
{
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function attempt($username, $password)
    {
        $user = $this->usersRepository->findUsername($username);
        if (empty($user)) {
            return false;
        }

        require __DIR__ . "/../System/salt.php";
        if (password_verify($user->salt . $password . $_ENV['salt'], $user->password)) {
            $_SESSION['login'] = $user->username;
            session_regenerate_id(true);
            return true;
        } else {
            return false;
        }
    }

    public function check()
    {
        if (isset($_SESSION['login'])) {
            return true;
        } else {
            header("Location: /app/index.php/login");
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['login']);
        session_regenerate_id(true);
    }
}

?>