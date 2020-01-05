<?php

namespace App\User;

use App\Core\AbstractRepository;

class PostsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\User\\RankModel";
    }

    public function insert($name, $post_add, $post_delete, $post_edit, $post_category_add, $post_category_delete, $post_category_edit, $post_comment_add, $post_comment_delete, $post_comment_edit, $user_add, $user_delete, $user_edit, $user_rank_add, $user_rank_delete, $user_rank_edit)
    {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare("INSERT INTO `{$table}` (`name`, `post_add`, `post_delete`, `post_edit`, `post_category_add`, `post_category_delete`, `post_category_edit`, `post_comment_add`, `post_comment_delete`, `post_comment_edit`, `user_add`, `user_delete`, `user_edit`, `user_rank_add`, `user_rank_delete`, `user_rank_edit`) VALUES (:name, :post_add, :post_delete, :post_edit, :post_category_add, :post_category_delete, :post_category_edit, :post_comment_add, :post_comment_delete, :post_comment_edit, :user_add, :user_delete, :user_edit, :user_rank_add, :user_rank_delete, :user_rank_edit)");
        $stmt->execute([
            'name' => $name,
            'post_add' => $post_add,
            'post_delete' => $post_delete,
            'post_edit' => $post_edit,
            'post_category_add' => $post_category_add,
            'post_category_delete' => $post_category_delete,
            'post_category_edit' => $post_category_edit,
            'post_comment_add' => $post_comment_add,
            'post_comment_delete' => $post_comment_delete,
            'post_comment_edit' => $post_comment_edit,
            'user_add' => $user_add,
            'user_delete' => $user_delete,
            'user_edit' => $user_edit,
            'user_rank_add' => $user_rank_add,
            'user_rank_delete' => $user_rank_delete,
            'user_rank_edit' => $user_rank_edit
        ]);
    }

    public function getTableName()
    {
        return "user_ranks";
    }

    public function update(RankModel $model)
    {
        $table = $this->getTableName();

        $stmt = $this->pdo->prepare("UPDATE `{$table}` SET `name` = :name, `post_add` = :post_add, `post_delete` = :post_delete, `post_edit` = :post_edit, `post_category_add` = :post_category_add, `post_category_delete` = :post_category_delete, `post_category_edit` = :post_category_edit, `post_comment_add` = :post_comment_add, `post_comment_delete` = :post_comment_delete, `post_comment_edit` = :post_comment_edit, `user_add` = :user_add, `user_delete` = :user_delete, `user_edit` = :user_edit, `user_rank_add` = :user_rank_add, `user_rank_delete` = :user_rank_delete, `user_rank_edit` = :user_rank_edit WHERE `id` = :id");
        $stmt->execute([
            'name' => $model->name,
            'post_add' => $model->post_add,
            'post_delete' => $model->post_delete,
            'post_edit' => $model->post_edit,
            'post_category_add' => $model->post_category_add,
            'post_category_delete' => $model->post_category_delete,
            'post_category_edit' => $model->post_category_edit,
            'post_comment_add' => $model->post_comment_add,
            'post_comment_delete' => $model->post_comment_delete,
            'post_comment_edit' => $model->post_comment_edit,
            'user_add' => $model->user_add,
            'user_delete' => $model->user_delete,
            'user_edit' => $model->user_edit,
            'user_rank_add' => $model->user_rank_add,
            'user_rank_delete' => $model->user_rank_delete,
            'user_rank_edit' => $model->user_rank_edit,
            'id' => $model->id
        ]);
    }
}

