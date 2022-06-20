<?php

namespace app\models;

use app\models\repositories\ActivityRepository;

class Activity extends Model
{

    public int $id;
    public string $title;
    public int $institute_id;
    public int $activity_type_id;
    public int $user_id;
    public int $age_from;
    public int $age_to;
    public int $amount_of_week;
    public int $duration_time;
    public float $price;
    public float $price_month;
    public string $contacts;


    public function __construct()
    {
        $this->repository = new ActivityRepository();
    }

    public function getAgeRange(): string
    {
        return "$this->age_from - $this->age_to лет";
    }

    public function getAmountOfWeek(): string
    {
        if ($this->amount_of_week != 2 && $this->amount_of_week != 3 && $this->amount_of_week != 4) 
        {
            return "$this->amount_of_week раз";
        }
        else 
        {
            return "$this->amount_of_week раза";
        }
        
    }
    protected  function getPage(int $last, int $paginate): array
    {
        return $this->repository->findPage($last, $paginate);
    }


}