<?php

namespace app\requests\admin;

use app\base\Request;

class TypesRequest extends Request
{
    protected array $errors = [];

    public function validate()
    {
        $params = $this->post();

        if (isset($params['title']) && empty($params['title']))
          $this->errors['title'] = 'Значение не заполнено!';

        return empty($this->errors) ? $params : false;
          
        //   $paramsNotification = [];
        //   if (isset($params['notification'])) {

        //       $paramsNotification =  $params['notification'];
        //       unset($params['notification']);
        //   }
        // if (empty($this->errors)) {

        //     // echo ('<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '---');
        //     // var_dump($this->params);
        //     // echo ('<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '---');
        //     // var_dump($this->errors);
        //     // die();

        //     return $params;
        // } else {
        //     return false;
        // }
    }

    public function errors(): array
    {
        return $this->errors;
    }
}