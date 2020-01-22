<?php

namespace App\Page;

use App\Core\AbstractRepository;

class PagesRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Page\\PageModel";
    }

    public function insert($title, $content)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`title`, `content`) VALUES (:title, :content)");
        $stmt->execute([
            'title' => $title,
            'content' => $content,
        ]);
    }

    public function getTableName()
    {
        return "pages";
    }

    public function update(PageModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `title` = :title, `content` = :content WHERE `id` = :id");
        $stmt->execute([
            'title' => $model->title,
            'content' => $model->content,
            'id' => $model->id
        ]);
    }
}
