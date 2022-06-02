<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_create_table_users_1654151282 extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `first_name` VARCHAR(255) NOT NULL,
            `last_name` VARCHAR(255) NOT NULL,
            `login` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) UNIQUE NOT NULL,
            `is_admin` TINYINT DEFAULT 0,
            `created_at` TIMESTAMP,
            `updated_at` TIMESTAMP
          );
        ";

        return $this->connection->query($row);
    }

    public function down()
    {
        $row = "
        DROP TABLE IF EXISTS `users`;
        ";

        return $this->connection->query($row);
    }
}
