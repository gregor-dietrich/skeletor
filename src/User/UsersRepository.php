<?php

namespace App\User;

use App\Core\AbstractRepository;
use PDO;

class UsersRepository extends AbstractRepository
{
    public function findUsername($username)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $user = $stmt->fetch(PDO::FETCH_CLASS);
        return $user;
    }

    public function getTableName()
    {
        return "users";
    }

    public function getModelName()
    {
        return "App\\User\\UserModel";
    }
}

