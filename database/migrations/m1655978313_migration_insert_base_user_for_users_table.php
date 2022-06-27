<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class m1655978313_migration_insert_base_user_for_users_table extends AbstractMigration
{
    public function up()
    {
        $row = "INSERT INTO `users` (`login`, `email`, `password`) VALUES ('FilterO_admin', 'admin@admin.com', MD5('PORtal_2@22/06'))";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "DELETE FROM `users` WHERE `email` = 'admin@admin.com'";

        return $this->connection->query($row);
    }

}