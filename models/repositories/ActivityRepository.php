<?php

namespace app\models\repositories;

use app\models\Activity;

class ActivityRepository extends RepositoryAbstract
{

    public function getTableName(): string
    {
        return 'activities';
    }

    public function getModelClassName(): string
    {
        return Activity::class;
    }

    public function findPage(int $last, int $paginate): array
    {   
        $sql = "SELECT * FROM activities LIMIT {$last}, {$paginate}";
        return $this->getQuery($sql, []);
        
    }
}