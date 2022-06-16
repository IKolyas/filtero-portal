<?php

namespace app\models;

use app\models\repositories\UserRepository;

class User extends Model
{

    public int $id;
    public string $first_name;
    public string $last_name;
    public string $login;
    public string $password;
    public string $email;
    public int $is_admin;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

}