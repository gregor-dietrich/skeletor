<?php

namespace App\Post;

use App\Core\AbstractRepository;
use PDO;

class CategoriesRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Post\\CategoryModel";
    }

    public function insert($name, $parent_id)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`name`, `parent_id`) VALUES (:name, :parent_id)");
        $stmt->execute([
            'name' => $name,
            'parent_id' => $parent_id
        ]);
    }

    public function getTableName()
    {
        return "post_categories";
    }

    public function update(CategoryModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `name` = :name, `parent_id` = :parent_id WHERE `id` = :id");
        $stmt->execute([
            'name' => $model->name,
            'parent_id' => $model->parent_id,
            'id' => $model->id
        ]);
    }

    public function fetchAllOrdered()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` ORDER BY `name` ASC");
        $stmt->execute();
        $children = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $children;
    }

    public function fetchAllByParentID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `parent_id` = :id ORDER BY `name` ASC");
        $stmt->execute(['id' => $id]);
        $children = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $children;
    }
}
