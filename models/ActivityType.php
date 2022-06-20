<?php

namespace app\models;

use app\models\repositories\ActivityTypeRepository;

class ActivityType extends Model
{
    public int $id;
    public string $title;

    public function __construct()
    {
        $this->repository = new ActivityTypeRepository();
    }
}