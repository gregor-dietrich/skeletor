<?php

namespace App\Post;

use App\Core\AbstractRepository;
use PDO;

class PostsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Post\\PostModel";
    }

    public function insert($title, $content, $user_id, $category_id)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`title`, `content`, `user_id`, `category_id`) VALUES (:title, :content, :user_id, :category_id)");
        $stmt->execute([
            'content' => $content,
            'title' => $title,
            'user_id' => $user_id,
            'category_id' => $category_id
        ]);
    }

    public function getTableName()
    {
        return "posts";
    }

    public function update(PostModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `content` = :content, `title` = :title, `category_id` = :category_id, `created` = :created WHERE `id` = :id");
        $stmt->execute([
            'content' => $model->content,
            'title' => $model->title,
            'category_id' => $model->category_id,
            'created' => $model->created,
            'id' => $model->id
        ]);
    }

    public function fetchAllByUserID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `user_id` = :id ORDER BY `id` DESC");
        $stmt->execute(['id' => $id]);
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $posts;
    }

    public function fetchAllByCategoryID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `category_id` = :id ORDER BY `id` DESC");
        $stmt->execute(['id' => $id]);
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $posts;
    }
}
