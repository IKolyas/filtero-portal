<?php


namespace app\database\migrations;

use app\database\AbstractMigration as AbstractMigration;

class migration_alter_user_table_add_cookie_column_1655209444 extends AbstractMigration
{
    public function up()
    {
        $row = "
        ALTER TABLE users
        ADD COLUMN cookie_key VARCHAR(255);
        ";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "
        ALTER TABLE users DROP COLUMN cookie_key;
        ";

        return $this->connection->query($row);
    }

}