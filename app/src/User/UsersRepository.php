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

    public function insert($username, $password, $salt, $rank_id, $email, $activated, $activation_key, $last_ip)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`username`, `password`, `salt`, `rank_id`, `email`, `activated`, `activation_key`, `last_ip`) VALUES (:username, :password, :salt, :rank_id, :email, :activated, :activation_key, :last_ip)");
        $stmt->execute([
            'username' => $username,
            'password' => $password,
            'salt' => $salt,
            'rank_id' => $rank_id,
            'email' => $email,
            'activated' => $activated,
            'activation_key' => $activation_key,
            'last_ip' => $last_ip
        ]);
    }

    public function update(UserModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `username` = :username, `password` = :password, `salt` = :salt, `rank_id` = :rank_id, `email` = :email, `last_ip` = :last_ip, `last_login` = :last_login WHERE `id` = :id");
        $stmt->execute([
            'username' => $model->username,
            'password' => $model->password,
            'salt' => $model->salt,
            'rank_id' => $model->rank_id,
            'email' => $model->email,
            'last_ip' => $model->last_ip,
            'last_login' => $model->last_login,
            'id' => $model->id
        ]);
    }
}
