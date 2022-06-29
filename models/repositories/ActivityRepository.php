<?php

namespace app\models\repositories;

use app\models\Activity;

class ActivityRepository extends RepositoryAbstract
{

    public string $query;

    protected array $searchFields = [
        'activities.title',
        'institutes.title',
        'activity_types.title',
        'activities.contacts',
        'activities.age_from',
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

    public function type(string $type): void
    {
        if($type) {
            if($type !== "default") {
                $this->query .= "WHERE activity_types.title = '{$type}' ";
            }
        }
    }

    public function institute(string $institute): void
    {
        if($institute) {
            if($institute !== "default") {
                if (strpos($this->query, "WHERE") !== false) {
                    $this->query .= "AND ";
                }
                else{
                    $this->query .= "WHERE ";
                }
                $this->query .= "institutes.title = '{$institute}' ";
            }
        }
    }

    public function age_from(string $age_from, string $age_to): void
    {
        if($age_from && $age_to) {
            if (strpos($this->query, "WHERE") !== false) {
                $this->query .= "AND ";
            }
            else{
                $this->query .= "WHERE ";
            }
            $this->query .= "activities.age_to >= '{$age_from}' AND activities.age_from <= '{$age_to}'";
            
        }
    }

    public function price(string $price_from, string $price_to): void
    {
        if($price_from && $price_to) {
            if (strpos($this->query, "WHERE") !== false) {
                $this->query .= "AND ";
            }
            else{
                $this->query .= "WHERE ";
            }
            $this->query .= "activities.price >= '{$price_from}' AND activities.price <= '{$price_to}'";
            
        }
    }

    public function search(string $search): void
    {
        if(!empty($this->searchFields) && strlen($search) > 0) {
            if (strpos($this->query, "WHERE") !== false) {

                $this->query .= "AND ";
            }
            else{
                $this->query .= "WHERE ";
            }

            foreach ($this->searchFields as $key => $field) {
                $this->query .= "{$field} REGEXP '({$search})' ";
                if($key !== count($this->searchFields) - 1) $this->query .= "OR ";
            }
        }
    }

    public function orderBy(string $order_by): void
    {
        if($order_by) {
            $this->query .= "ORDER BY {$order_by} ";
        }
    }

    public function order(string $order): void
    {
        if($order) {
            $this->query .= "{$order}";
        }
    }

    public function paginate(int $offset, int $paginate): void
    {
        $this->query .= " LIMIT {$offset}, {$paginate}";
    }

    public function leftJoin(string $table, string $for_key, string $prim_key): void
    {
        $this->query .= "LEFT JOIN {$table} ON {$prim_key} = {$for_key} ";
    }

    public function getAgesFrom(): array
    {
        $sql = "SELECT age_from FROM {$this->getTableName()} ";
        return $this->getQuery($sql, []);
        
    }

    public function getAgesTo(): array
    {
        $sql = "SELECT age_to FROM {$this->getTableName()} ";
        return $this->getQuery($sql, []);
        
    }

    public function getPrice(): array
    {
        $sql = "SELECT price FROM {$this->getTableName()} ";
        return $this->getQuery($sql, []);
        
    }
}