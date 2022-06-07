<?php

namespace app\requests;

use app\base\Request;

class RegistrationRequest extends Request
{
    protected array $fields = [
        'first_name',
        'last_name',
        'login',
        'password',
        'email'
    ];

    protected array $errors = [];


    public function validate()
    {
        $params = $this->post();

        if(empty($params))
            $this->errors['empty_fields'] = $this->fields;

        foreach ($this->fields as $key => $val) {
            if(empty($params[$val] || !is_string($params[$val])))
                $this->errors[$val] = 'Значение не является строкой или не заполнено!';
        }
        if(strlen($params['password']) < 8)
            $this->errors['password'] = 'Длина пароля меньше 8 символов';

        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }

}