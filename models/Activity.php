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
        return "С $this->age_from по $this->age_to";
    }


}