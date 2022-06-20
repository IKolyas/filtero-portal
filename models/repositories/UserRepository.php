<?php

namespace app\models\repositories;

use app\models\User;

class UserRepository extends RepositoryAbstract
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return User::class;
    }

}