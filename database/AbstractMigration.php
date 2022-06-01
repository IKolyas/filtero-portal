<?php

namespace app\database;
use app\services\DataBase as DataBase;

abstract class AbstractMigration
{
    protected $connection = null;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

    abstract public function up();

    abstract public function down();
}