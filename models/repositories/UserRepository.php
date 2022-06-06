<?php

namespace app\models\repositories;

class UserRepository extends RepositoryAbstract
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return 'users';
    }
}