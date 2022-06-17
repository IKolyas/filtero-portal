<?php

namespace app\models;

use app\models\repositories\RepositoryAbstract;

abstract class Model
{

    protected ?RepositoryAbstract $repository;

    protected function find($value, string $col = 'id'): ?Model
    {
        return $this->repository->getOne($value, $col);
    }

    protected function findAll(): ?array
    {
        return $this->repository->getAll();
    }


    protected function update($fields): int

    {
        return $this->repository->update($fields);
    }

    protected function create($values): int
    {
        return $this->repository->add($values);
    }

    protected function delete($values): int
    {
        return $this->repository->delete($values);
    }

    /**
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if(method_exists(static::class, $name)) {
            $class = new static();
            return $class->$name(...$arguments);
        } else {
            throw new \Exception("Метод $name не существует в экземпляре класса " . static::class);
        }
    }

}