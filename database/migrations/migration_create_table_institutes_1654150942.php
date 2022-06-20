<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_create_table_institutes_1654150942 extends AbstractMigration
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
