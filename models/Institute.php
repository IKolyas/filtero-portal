<?php

namespace app\models;

use app\models\repositories\InstitutesRepository;

class Institute extends Model
{

    public int $id;
    public string $title;

    public function __construct()
    {
        $this->repository = new InstitutesRepository();
    }
}