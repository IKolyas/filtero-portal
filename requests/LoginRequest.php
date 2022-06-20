<?php

namespace app\requests;

use app\base\Request;

class LoginRequest extends Request
{

      protected string $regular_password = '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/';
      protected string $regular_email = '/[0-9a-z]+@[a-z]/';

      protected array $fields = [
            'password',
            'email'
      ];

      protected array $errors = [];

      public function validate()
      {
            $params = $this->post();

            if(empty($params))
                  $this->errors['empty_fields'] = $this->fields;

            foreach($this->fields as $key => $value)
            {
                  if(empty($params[$value]) && !is_string($value))
                        $this->errors[$value] = 'Значение не является строкой или не заполнено!';
            }

            if(!preg_match($this->regular_password, $params['password']))
                  $this->errors['password'] = 'Пароль должен состоять из цифр и латинских букв верхнего и нижнего регистра и длина должна быть не менее 8 символов!';
            
            if(!preg_match($this->regular_email, $params['email']))
                  $this->errors['email'] = 'Неверный формат электронной почты';

            return empty($this->errors) ? $params : false;


      }

    
      public function errors(): array
      {
            return $this->errors;
      }
}