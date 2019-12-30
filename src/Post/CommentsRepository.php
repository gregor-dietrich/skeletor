<?php

namespace App\Post;

use PDO;
use App\Core\AbstractRepository;

class CommentsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Post\\CommentModel";
    }

    public function getTableName()
    {
        return "post_comments";
    }

    public function addByID($post_id, $content) {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `$table` (`content`, `post_id`) VALUES (:content, :post_id)");
        $stmt->execute([
            'content' => $content,
            'post_id' => $post_id
            ]);
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
}

?>