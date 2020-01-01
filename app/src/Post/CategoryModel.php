<?php

namespace App\Post;

use App\Core\AbstractModel;

class CategoryModel extends AbstractModel
{
    public $id;
    public $name;
    public $parent_id;
}