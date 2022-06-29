<?php

namespace app\requests\admin;

use app\base\Request;
use app\models\ActivityType;

class TypesRequest extends Request
{
    protected array $errors = [];

    public function validate($action = null)
    {
        $params = $this->post();
        
        if ($action == 'create') {
            if (ActivityType::find($params['title'], 'title'))
                $this->errors['title'] = 'Значение уже существует!';
        }

        if ($action == 'update') {
            $findTitle = ActivityType::find($params['title'], 'title');
            if ($findTitle) {
                $findId = get_object_vars($findTitle)['id'];
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