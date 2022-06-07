<?php

namespace app\models\repositories;

use app\models\Model;

interface RepositoryInterface
{

    public function getAll(): array;

    public function getBy($value, string $column = 'id'): array;

    public function getOne(string $value, string $column): ?Model;

    public function add(array $params): int;

    public function update(array  $params): int;

    public function delete(int $id): int;

    function save(string $sql, array $params = []): int;

    public function getQuery(string $sql, array $params = []): array;

    public function getTableName(): string;

    public function getModelClassName(): string;
}