<?php

namespace App\User;

use App\Core\AbstractRepository;

class GroupsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\User\\GroupModel";
    }

    public function insert($name)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`name`) VALUES (:name)");
        $stmt->execute([
            'name' => $name,
        ]);
    }

    public function getTableName()
    {
        return "user_groups";
    }

    public function update(GroupModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `name` = :name WHERE `id` = :id");
        $stmt->execute([
            'name' => $model->name,
            'id' => $model->id
        ]);
    }
}
