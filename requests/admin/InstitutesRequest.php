<?php

namespace app\requests\admin;

use app\base\Request;
use app\models\Institute;

class InstitutesRequest extends Request
{
    protected array $errors = [];

    public function validate($action = null)
    {
        $params = $this->post();

        if ($action == 'create') {
            if (Institute::find($params['title'], 'title'))
                $this->errors['title'] = 'Значение уже существует!';
        }

        if ($action == 'update') {
            $findActivity = Institute::find($params['title'], 'title');
            if ($findActivity) {
                $findId = $findActivity->id;
                if ($findId != $params['id']) {
                    $this->errors['title'] = 'Значение уже существует!';
                }
            }
        }

        if (isset($params['title']) && empty($params['title']))
          $this->errors['title'] = 'Значение не заполнено!';
        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}