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
        $sql = "SELECT * FROM activities ORDER BY title LIMIT {$last}, {$paginate}";
        return $this->getQuery($sql, []);
    }

    public function search(array $params, int $paginate = 100): array
    {
        $offset = 0;

        if(isset($params['offset'])) {
            $offset = $params['offset'];
            unset($params['offset']);
        }

        $sql = "SELECT * FROM activities ";

        if(!empty($this->searchFields) && isset($params['search'])) {
            $sql .= "WHERE ";

            foreach ($this->searchFields as $key => $field) {
                $sql .= "{$field} LIKE '%{$params['search']}%' ";
                if($key !== count($this->searchFields) - 1) $sql .= "OR ";
            }

        }

        if(isset($params['order_by'])) {
            $sql .= "ORDER BY {$params['order_by']} ";
        }

        if(isset($params['order'])) {
            $sql .= "{$params['order']}";
        }

        $sql .= " LIMIT {$offset}, {$paginate}";

        return $this->getQuery($sql, []);
    }
}