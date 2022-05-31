<?php

namespace app\database\migrations;
use app\database\migrations\AbstractMigration as AbstractMigration;

class migration_create_table_users_31052011 extends AbstractMigration
{
    public function up(): int
    {
        $row = "
            CREATE TABLE IF NOT EXISTS `users` (
              `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `login` VARCHAR(255) NOT NULL UNIQUE,
              `password` VARCHAR(255) NOT NULL,
              `email` VARCHAR(255) UNIQUE NOT NULL,
              `is_admin` TINYINT DEFAULT 0
            );
        ";

        return $this->connection->execute($row);

    }

    public function down()
    {
        $row = "
            DROP TABLE IF EXISTS `users`;
        ";

        return $this->connection->execute($row);
    }

}