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

    public function randomCookie()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphabetLen = strlen($alphabet);
        $cookieLen = 10;
        for($i = 0; $i <= $cookieLen; $i++)
        {
            $n = rand(0, $alphabetLen);
            $pass = $alphabet[$n];
        }
        return implode($pass);
    }

    public function setCokieUsre ($cookie_key, $time = 30)
    {
        setcookie('auth', $cookie_key, time() + $time, '/');        
    }

    public function setCookieKeyDb($user_id, $cookie_key)
    {
        $this->update();
    }

    public function setSessionUser($value)
    {
        app()->session();
        $set_sessin = app()->session->set('user', $value);
    }


}