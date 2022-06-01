<?php

$action = $_SERVER['argv'][1] ?? false;
$migrationName = $_SERVER['argv'][2] ?? false;

include "../vendor/autoload.php";


function migrationGenerateContent($migrationName): string
{
    return '<?php

namespace app\database\migrations;
use app\database\migrations\AbstractMigration as AbstractMigration;

class ' . $migrationName . ' extends AbstractMigration
{
    public function up(): int
    {
        $row = "";
        
        return $this->connection->execute($row);

    }

    public function down()
    {
        $row = "";

        return $this->connection->execute($row);
    }

}';
}

if ($action && $migrationName) {

    switch ($action) {
        case "create":
            $migrationName = "migration_" . $migrationName . "_" . time();
            $dir = "./migrations/";
            $fileName = $migrationName . ".php";
            file_put_contents($dir . $fileName, migrationGenerateContent($migrationName));
            print_r("\n Миграция $migrationName успешно создана! \n");
            break;
        case "up":
            $dir = scandir('./migrations/');
            foreach ($dir as $file) {
                if (basename($file) == $migrationName) {
                    $migrationName = explode('.', $migrationName)[0];
                    $class = "app\\database\\migrations\\$migrationName";
                    $migration = new $class();
                    print_r($migration->up() . "\n");
                }
            }
            break;
        case "down":
            $dir = scandir('./migrations/');
            foreach ($dir as $file) {
                if (basename($file) == $migrationName) {
                    $migrationName = explode('.', $migrationName)[0];
                    $class = "app\\database\\migrations\\$migrationName";
                    $migration = new $class();
                    print_r($migration->down() . "\n");
                }
            }
            break;
        case "drop":
            $dir = "./migrations/";
            $fileName = $migrationName;
            $filePath = $dir . $fileName;

            $dirScan = scandir('./migrations/');
            foreach ($dirScan as $file) {
                if (basename($file) == $migrationName) {
                    print_r($migrationName . PHP_EOL . PHP_EOL);
                    print_r($filePath . PHP_EOL . PHP_EOL);
                    unlink($filePath);
                }
            }
            break;
        default:
    }
}
