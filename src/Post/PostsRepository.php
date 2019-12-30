<?php

namespace App\Post;

use App\Core\AbstractRepository;

class PostsRepository extends AbstractRepository
{
    public function getModelName()
    {
        return "App\\Post\\PostModel";
    }

    public function getTableName()
    {
        return "posts";
    }
}

?>