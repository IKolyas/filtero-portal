<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_create_table_activity_types_1654144496 extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `activity_types` 
        (`id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL);
        ";

        return $this->connection->query($row);
    }

    public function down()
    {
        $row = "
        DROP TABLE IF EXISTS `activity_types`;
        ";

        return $this->connection->query($row);
    }
}
