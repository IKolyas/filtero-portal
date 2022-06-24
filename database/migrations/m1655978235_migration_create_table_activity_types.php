<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class m1655978235_migration_create_table_activity_types extends AbstractMigration
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