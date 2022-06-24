<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class m1655978104_migration_create_table_activities extends AbstractMigration
{
    public function up()
    {
        $row = "
        CREATE TABLE IF NOT EXISTS `activities` (
            `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) UNIQUE NOT NULL,
            `institute_id` BIGINT,
            `activity_type_id` BIGINT,            
            `user_id` BIGINT,
            `age_from` INT,
            `age_to` INT,
            `amount_of_week` INT,
            `duration_time` INT,
            `price` FLOAT,
            `price_month` FLOAT,
            `contacts` TEXT,
            `created_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`) ON DELETE SET NULL,
            FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE SET NULL,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
        );
        ";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "
        DROP TABLE IF EXISTS `activities`;
        ";

        return $this->connection->query($row);
    }

}