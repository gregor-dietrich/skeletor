<?php

namespace App\Post;

use App\Core\AbstractRepository;

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
}
