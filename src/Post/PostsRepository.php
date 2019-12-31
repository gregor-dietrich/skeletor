<?php

namespace App\Post;

use App\Core\AbstractRepository;

class PostsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Post\\PostModel";
    }

    public function insert($title, $content)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`title`, `content`) VALUES (:title, :content)");
        $stmt->execute([
            'content' => $content,
            'title' => $title
        ]);
    }

    public function getTableName()
    {
        return "posts";
    }

    public function update(PostModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `content` = :content, `title` = :title WHERE `id` = :id");
        $stmt->execute([
            'content' => $model->content,
            'title' => $model->title,
            'id' => $model->id
        ]);
    }
}

