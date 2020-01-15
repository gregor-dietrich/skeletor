<?php

namespace App\User;

use App\Core\AbstractModel;

class UserModel extends AbstractModel
{
    public $id;
    public $username;
    public $password;
    public $salt;
    public $rank_id;
    public $email;
    public $activated;
    public $activation_key;
    public $last_ip;
    public $created;
    public $last_login;
}
