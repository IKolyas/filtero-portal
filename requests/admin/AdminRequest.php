<?php

namespace app\requests\admin;

use app\base\Request;

class AdminRequest extends Request
{
    protected string $reguler_password = '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/';
    protected string $reguler_email = '/[0-9a-z]+@[a-z]/';

    protected array $fields = [
        'types' => ['title'],
        'institutes' => ['title'],
        'users' => ['first_name', 'last_name', 'login', 'password', 'email'],
        'activities' => ['title', 'institute_id', 'activity_type_id', 'age_from', 'age_to', 'amount_of_week', 'duration_time', 'price', 'price_month', 'contacts']
    ];

    protected array $errors = [];

    public function validate($tabsName)
    {
        $params = $this->post();

        if(empty($params)) 
            $this->errors['empty_fields'] = $this->fields[$tabsName];        

        foreach ($this->fields as $key => $val) {
        
            if(empty($params[$val] || !is_string($params[$val])))
            
                $this->errors[$val] = 'Значение не является строкой или не заполнено!';
        }

        
        if (isset($params['first_name']) && strlen($params['first_name']) < 3)
            $this->errors['first_name'] = 'Длинна поля меньше 3 символов';

        if(isset($params['password']) && !preg_match($this->reguler_password, $params['password']))
            $this->errors['password'] = 'Пароль должен состоять из цифр, символов и латинских букв верхнего и нижнего регистра и длина должна быть не менее 8 символов!';
    
        if (isset($params['email']) && !preg_match($this->reguler_email, $params['email']))
            $this->errors['email'] = 'Неверный формат электронной почты';

        // if (isset($params['password_r']) && !($params['password'] == $params['password_r']))
        //     $this->errors['password_r'] = 'Пароли не совпадают!';
            
        if (isset($params['institute_id']) && $params['institute_id'] == 'Выберете учреждение') {
            $this->errors['institute_id'] = 'Выберите институт!';
        }

        if (isset($params['activity_type_id']) && $params['activity_type_id'] == 'Выберете тип') {
            $this->errors['activity_type_id'] = 'Выберите тип!';
        }
        
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