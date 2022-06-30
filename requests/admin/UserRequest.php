<?php

namespace app\requests\admin;

use app\base\Request;
use app\models\User;

class UserRequest extends Request
{
    protected string $reguler_password = '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/';
    protected string $reguler_email = '/[0-9a-z]+@[a-z]/';

    protected array $errors = [];

    public function validate($action = null)
    {
        $params = $this->post();

        if ($action == 'create') {
            if (User::find($params['login'], 'login'))
                $this->errors['login'] = 'Значение уже существует!';

            if (User::find($params['email'], 'email'))
                $this->errors['email'] = 'Значение уже существует!';
        }

        if ($action == 'update') {
            $findLogin = User::find($params['login'], 'login');
            if ($findLogin) {
                $findId = $findLogin->id;
                if ($findId != $params['id']) {
                    $this->errors['login'] = 'Значение уже существует!';
                }
            }

            $findEmail = User::find($params['email'], 'email');
            if ($findEmail) {
                $findId = $findEmail->id;
                if ($findId != $params['id']) {
                    $this->errors['email'] = 'Значение уже существует!';
                }
            }
        }

        if (isset($params['first_name']) && empty($params['first_name']))
          $this->errors['first_name'] = 'Значение не заполнено!';

        if (isset($params['last_name']) && empty($params['last_name']))
          $this->errors['last_name'] = 'Значение не заполнено!';

        if (isset($params['login']) && empty($params['login']))
          $this->errors['login'] = 'Значение не заполнено!';
            
        if(isset($params['password']) && !preg_match($this->reguler_password, $params['password']))
            $this->errors['password'] = 'Пароль должен состоять из цифр, символов и латинских букв верхнего и нижнего регистра и длина должна быть не менее 8 символов!';

        if (isset($params['email']) && !preg_match($this->reguler_email, $params['email']))
            $this->errors['email'] = 'Неверный формат электронной почты';
        
        if (isset($params['password'])) {
            $params['password'] = $params['password'] ?: md5($params['password']);
        }
        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}