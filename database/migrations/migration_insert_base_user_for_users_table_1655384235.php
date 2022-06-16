<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_insert_base_user_for_users_table_1655384235 extends AbstractMigration
{
    public function up()
    {
        $row = "INSERT INTO `users` (`login`, `email`, `password`) VALUES ('admin', 'admin@admin.com', 'password')";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "DELETE FROM `users` WHERE `email` = 'admin@admin.com'";

        return $this->connection->query($row);
    }

}