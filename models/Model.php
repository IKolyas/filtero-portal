<?php

namespace app\models;

use app\models\repositories\RepositoryAbstract;

abstract class Model
{
    protected int $id;

    protected ?RepositoryAbstract $repository;

    public function find($id): ?User
    {
        return $this->repository->getOne($id)[0];
    }

    public function findAll(): array
    {
        return $this->repository->getAll();
    }

    public function update(): int
    {
        $values = get_object_vars($this);
        unset($values['repository']);
        return $this->repository->update($values);
    }

    public function create($values): int
    {
        return $this->repository->add($values);
    }

}