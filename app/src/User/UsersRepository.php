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

    public function insert($username, $password, $salt)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`username`, `password`, `salt`) VALUES (:username, :password, :salt)");
        $stmt->execute([
            'username' => $username,
            'password' => $password,
            'salt' => $salt
        ]);
    }

    public function update(UserModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `username` = :username, `password` = :password, `salt` = :salt WHERE `id` = :id");
        $stmt->execute([
            'username' => $model->username,
            'password' => $model->password,
            'salt' => $model->salt,
            'id' => $model->id
        ]);
    }
}

