<?php

namespace app\requests\admin;

use app\base\Request;
use app\models\Activity;

class ActivitiesRequest extends Request
{
    protected array $errors = [];

    public function validate($action = null)
    {
        $params = $this->post();
          
        if (isset($params['title']) && empty($params['title']))
          $this->errors['title'] = 'Значение не заполнено!';
          
        if (isset($params['institute_id']) && $params['institute_id'] == 'Выберите учреждение') 
          $this->errors['institute_id'] = 'Выберите институт!';
        
        if (isset($params['activity_type_id']) && $params['activity_type_id'] == 'Выберите тип') 
          $this->errors['activity_type_id'] = 'Выберите тип!';

        if (isset($params['age_from']) && empty($params['age_from']))
          $this->errors['age_from'] = 'Значение не заполнено!';

        if (isset($params['age_to']) && empty($params['age_to']))
          $this->errors['age_to'] = 'Значение не заполнено!';

        if (isset($params['amount_of_week']) && empty($params['amount_of_week']))
          $this->errors['amount_of_week'] = 'Значение не заполнено!';

        if (isset($params['duration_time']) && empty($params['duration_time']))
          $this->errors['duration_time'] = 'Значение не заполнено!';

        if (isset($params['price']) && empty($params['price']))
          $this->errors['price'] = 'Значение не заполнено!';

        if (isset($params['price_month']) && empty($params['price_month']))
          $this->errors['price_month'] = 'Значение не заполнено!';

        if (isset($params['contacts']) && empty($params['contacts']))
          $this->errors['contacts'] = 'Значение не заполнено!';
                
        return empty($this->errors) ? $params : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}



