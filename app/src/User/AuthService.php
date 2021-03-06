<?php

namespace App\User;

class AuthService
{
    public function __construct(UsersRepository $usersRepository, RanksRepository $ranksRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->ranksRepository = $ranksRepository;
    }

    public function attempt($username, $password)
    {
        $user = $this->usersRepository->findUsername($username);
        if (empty($user)) {
            return false;
        }
        require __DIR__ . "/../System/salt.php";
        if (password_verify($user->salt . $password . $_ENV['salt'], $user->password)) {
            unset($_ENV['salt']);
            return true;
        } else {
            unset($_ENV['salt']);
            return false;
        }
    }

    public function checkAccess()
    {
        return $this->check();
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
