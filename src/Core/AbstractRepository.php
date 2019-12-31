<?php

namespace App\Core;

use PDO;

abstract class AbstractRepository
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function delete($id)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("DELETE FROM `{$table}` WHERE `{$table}`.`id` = :id");
        $stmt->execute(['id' => $id]);
    }

    abstract public function getTableName();

    function findAll()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->query("SELECT * FROM `$table`");
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        return $posts;
    }

    abstract public function getModelName();

    function findID($id)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $post = $stmt->fetch(PDO::FETCH_CLASS);
        return $post;
    }
}

?>