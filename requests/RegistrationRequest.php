<?php

namespace app\requests;

use app\base\Request;

class RegistrationRequest extends Request
{
    protected string $reguler_password = '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/';
    protected string $reguler_email = '/[0-9a-z]+@[a-z]/';
    protected array $fields = [
        'first_name',
        'last_name',
        'login',
        'password',
        'email',
        'password_r'
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
        if(!preg_match($this->reguler_password, $params['password']))
            $this->errors['password'] = 'Пароль должен состоять из цифр и латинских букв верхнего и нижнего регистра и длина должна быть не менее 8 символов!';

    
        if (!preg_match($this->reguler_email, $params['email']))
            $this->errors['email'] = 'Неверный формат электронной почты';

        if (!($params['password'] == $params['password_r']))
            $this->errors['password_r'] = 'Пароли не совпадают!';
            
        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }

}