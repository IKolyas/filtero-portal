<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class m1655978275_migration_create_table_users extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `first_name` VARCHAR(255) DEFAULT 'user',
            `last_name` VARCHAR(255) DEFAULT 'last_name',
            `login` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) UNIQUE NOT NULL,
            `is_admin` TINYINT DEFAULT 0,
            `cookie_key` VARCHAR(255),
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