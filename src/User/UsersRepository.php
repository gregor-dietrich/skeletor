<?php

namespace App\User;

use PDO;
use App\Core\AbstractRepository;

class UsersRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\User\\UserModel";
    }

    public function getTableName()
    {
        return "users";
    }

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
}

?>