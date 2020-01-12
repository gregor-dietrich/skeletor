<?php

namespace App\User;

use App\Core\AbstractRepository;
use PDO;

class GroupmetasRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\User\\GroupmetaModel";
    }

    public function getTableName()
    {
        return "user_groups_meta";
    }

    public function insert($user_id, $group_id)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`user_id`, `group_id`) VALUES (:user_id, :group_id)");
        $stmt->execute([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);
    }

    public function fetchAllByGroupID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `group_id` = :id");
        $stmt->execute(['id' => $id]);
        $user_ids = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $user_ids;
    }

    public function fetchAllByUserID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `user_id` = :id");
        $stmt->execute(['id' => $id]);
        $group_ids = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $group_ids;
    }

    public function remove($user_id, $group_id)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE `user_id` = :user_id AND `group_id` = :group_id");
        $stmt->execute([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);
    }
}
