<?php

namespace app\requests\admin;

use app\base\Request;

class InstitutesRequest extends Request
{
    protected array $errors = [];

    public function validate()
    {
        $params = $this->post();

        if (isset($params['title']) && empty($params['title']))
          $this->errors['title'] = 'Значение не заполнено!';
        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}