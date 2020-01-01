<?php

namespace App\User;

use App\Core\AbstractModel;

class RankModel extends AbstractModel
{
    public $id;
    public $name;
    public $comment_delete;
    public $post_add;
    public $post_delete;
    public $post_edit;
    public $user_add;
    public $user_delete;
    public $user_edit;
}