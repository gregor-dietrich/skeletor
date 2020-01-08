<?php

namespace App\Post;

use App\Core\AbstractRepository;
use PDO;

class CommentsRepository extends AbstractRepository
{
    public function addByID($post_id, $content, $user_id)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `$table` (`content`, `post_id`, `user_id`) VALUES (:content, :post_id, :user_id)");
        $stmt->execute([
            'content' => $content,
            'post_id' => $post_id,
            'user_id' => $user_id
        ]);
    }

    public function getTableName()
    {
        return "post_comments";
    }

    public function fetchAllByID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `post_id` = :id");
        $stmt->execute(['id' => $id]);
        $comments = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $comments;
    }

    public function getModelName()
    {
        return "App\\Post\\CommentModel";
    }
}

