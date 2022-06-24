<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class m1655978255_migration_create_table_institutes extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `institutes` (
            `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL
        );
        ";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "
        DROP TABLE IF EXISTS `institutes`
        ";

        return $this->connection->query($row);
    }

}