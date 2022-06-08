<?php

namespace app\models\repositories;

use app\models\Institute;

class InstitutesRepository extends RepositoryAbstract
{

    public function getTableName(): string
    {
        return 'institutes';
    }

    public function getModelClassName(): string
    {
        return Institute::class;
    }
}