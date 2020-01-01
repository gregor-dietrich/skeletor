<?php

namespace App\User;

use App\Core\AbstractModel;

class UserModel extends AbstractModel
{
    public $id;
    public $username;
    public $password;
    public $salt;
    public $rank;
}

