<?php

namespace app\models\repositories;

use app\models\Activity;

class ActivityRepository extends RepositoryAbstract
{

    public string $query;

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

    public function select(array $fields)
    {
        $fields = !empty($fields) ? implode(', ', $fields) : "*";
        $this->query = "SELECT {$fields} FROM {$this->getTableName()} ";
    }

    public function search(array $params, int $paginate = 100): void
    {
        $offset = 0;

        if(isset($params['offset'])) {
            $offset = $params['offset'];
            unset($params['offset']);
        }

        if(!empty($this->searchFields) && isset($params['search'])) {
            $this->query .= "WHERE ";

            foreach ($this->searchFields as $key => $field) {
                $this->query .= "{$field} LIKE '%{$params['search']}%' ";
                if($key !== count($this->searchFields) - 1) $this->query .= "OR ";
            }

        }

        if(isset($params['order_by'])) {
            $this->query .= "ORDER BY {$params['order_by']} ";
        }

        if(isset($params['order'])) {
            $this->query .= "{$params['order']}";
        }

        $this->query .= " LIMIT {$offset}, {$paginate}";
    }

    public function leftJoin(string $table, string $for_key, string $prim_key): void
    {
        $this->query .= "LEFT JOIN {$table} ON {$prim_key} = {$for_key} ";
    }
}