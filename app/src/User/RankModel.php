<?php

namespace App\User;

use App\Core\AbstractModel;

class RankModel extends AbstractModel
{
    public $id;
    public $name;
    public $post_add;
    public $post_delete;
    public $post_edit;
    public $post_category_add;
    public $post_category_delete;
    public $post_category_edit;
    public $post_comment_add;
    public $post_comment_edit;
    public $post_comment_delete;
    public $user_add;
    public $user_delete;
    public $user_edit;
    public $user_rank_add;
    public $user_rank_delete;
    public $user_rank_edit;
}
