<?php

namespace app\models;

use app\models\repositories\RepositoryAbstract;

abstract class Model
{
    protected int $id;

    protected ?RepositoryAbstract $repository;

    protected function find(int $id): ?User
    {
        return $this->repository->getOne($id);
    }

    protected function findAll(): array
    {
        return $this->repository->getAll();
    }

    protected function update(): int
    {
        $fields = get_object_vars($this);
        unset($fields['repository']);
        return $this->repository->update($fields);
    }

    protected function create($values): int
    {
        return $this->repository->add($values);
    }

    public static function __callStatic($name, $arguments)
    {
        if(method_exists(static::class, $name)) {
            $class = new static();
            return $class->$name(...$arguments);
        }
        return false;
    }

}