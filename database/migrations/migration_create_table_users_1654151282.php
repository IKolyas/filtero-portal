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
            `name` VARCHAR(255) NOT NULL,
            `login` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) UNIQUE NOT NULL,
            `is_admin` TINYINT DEFAULT 0
          );
        ";

        return $this->connection->query($row);
    }

    public function down()
    {
        $row = "
        DROP TABLE `users`;
        ";

        return $this->connection->query($row);
    }
}
