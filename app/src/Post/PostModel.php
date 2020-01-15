<?php

namespace App\Post;

use App\Core\AbstractModel;

class PostModel extends AbstractModel
{
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $category_id;
    public $published;
    public $commentable;
    public $created;
    public $last_edit;
}
