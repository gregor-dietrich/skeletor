<?php

namespace App\User;

use App\Core\AbstractRepository;

class GroupsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\User\\GroupModel";
    }

    public function getTableName()
    {
        return "user_groups";
    }

    public function insert($name, $users)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`name`, `users`) VALUES (:name, :users)");
        $stmt->execute([
            'name' => $name,
            'users' => $users,
        ]);
    }

    public function update(GroupModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `name` = :name, `users` = :users WHERE `id` = :id");
        $stmt->execute([
            'name' => $model->name,
            'users' => $model->users,
            'id' => $model->id
        ]);
    }
}
