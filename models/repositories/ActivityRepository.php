<?php

namespace app\models\repositories;

use app\models\Activity;

class ActivityRepository extends RepositoryAbstract
{

    protected array $searchFields = [
        'title',
        'contacts'
    ];

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

    public function search(int $last, int $paginate, string $sql_search): array
    {
        $sql = "SELECT * FROM activities WHERE 
                             {$this->searchFields[0]} LIKE '%{$sql_search}%'
                             OR
                             {$this->searchFields[1]} LIKE '%{$sql_search}%'
                             LIMIT {$last}, {$paginate}";
        return $this->getQuery($sql, []);
    }
}