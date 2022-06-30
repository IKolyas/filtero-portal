<?php

namespace app\models\repositories;

use app\models\Model;
use app\services\DataBase;

abstract class RepositoryAbstract implements RepositoryInterface
{

    protected ?DataBase $dataBase;
    protected string $tableName;


    public function __construct()
    {
        $this->dataBase = DataBase::getInstance();
        $this->tableName = $this->getTableName();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->getQuery($sql, []);
    }

    public function getBy($value, string $column = 'id'): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$column} = :value";
        return $this->getQuery($sql, ['value' => $value]);
    }

    public function getOne($value, string $column = 'id'): ?Model
    {
        return $this->getBy($value, $column) ? $this->getBy($value, $column)[0] : null;
    }

    public function add(array $params): int
    {
        $paramsList = [];
        $columns = [];

        foreach ($params as $key => $value) {
            if ($key !== 'id') {
                $paramsList[":{$key}"] = $value;
                $columns[] = "`{$key}`";
            }
        }

        $paramsValue = implode(',', array_keys($paramsList));
        $columns = implode(',', $columns);

        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$paramsValue})";

        return $this->save($sql, $paramsList);
    }

    public function update(array $params): int
    {
        $paramsList = [];
        $columns = [];

        foreach ($params as $key => $value) {
            $paramsList[":{$key}"] = $value;
            if ($key !== 'id') {
                $columns[] = "`$key`" . '=' . ":{$key}";
            }
        }
        $columns = implode(', ', $columns);

        $sql = "UPDATE {$this->tableName} SET {$columns} WHERE `id` = :id";

        return $this->save($sql, $paramsList);
    }

    public function delete(int $id): int
    {
        $sql = "DELETE FROM {$this->tableName} WHERE `id` = :id";
        return $this->save($sql, [':id' => $id]);
    }

    public function save(string $sql, array $params = []): int
    {
        return $this->dataBase->execute($sql, $params);
    }

    public function getQuery(string $sql, array $params = []): array
    {
        return $this->dataBase->queryAll($sql, $params, $this->getModelClassName());
    }

    abstract public function getTableName(): string;

    abstract public function getModelClassName(): string;
}