<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_create_table_activities_1654151431 extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `activities` (
            `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) UNIQUE NOT NULL,
            `institute_id` BIGINT,
            `activity_id` BIGINT,
            `age_from` INT,
            `age_to` INT,
            `amount_of_week` INT,
            `duration_time` INT,
            `price` FLOAT,
            `price_month` FLOAT,
            `contacts` TEXT,
            `created_at` TIMESTAMP,
            `updated_at` TIMESTAMP,
            `user_id` BIGINT,
            FOREIGN KEY (`activity_id`) REFERENCES `activity_types` (`id`),
            FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        );
        ";

        return $this->connection->query($row);
    }

    public function down()
    {
        $row = "
        DROP TABLE `activities`;
        ";

        return $this->connection->query($row);
    }
}
