<?php

namespace app\models\repositories;

use app\models\ActivityType;

class ActivityTypeRepository extends RepositoryAbstract
{

    public function getTableName(): string
    {
        return 'activity_types';
    }

    public function getModelClassName(): string
    {
        return ActivityType::class;
    }
}