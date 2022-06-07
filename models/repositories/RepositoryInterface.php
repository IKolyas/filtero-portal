<?php

namespace app\models\repositories;

interface RepositoryInterface
{

    public function getAll(): array;

    public function getBy($value, string $column = 'id'): array;

    public function getOne(string $value, string $column): array;

    public function add(array $params): int;

    public function update(array  $params): int;

    public function delete(int $id): int;

    function save(string $sql, array $params = []): int;

    public function getQuery(string $sql, array $params = []): array;

    public function getTableName(): string;

    public function getModelClassName(): string;
}