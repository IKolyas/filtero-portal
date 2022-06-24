<?php

namespace app\services;

use app\database\AbstractMigration;
use app\services\ExceptionMessenger;

class MigrationService
{

    public string $migrations_path;
    public string $migration_example_path;
    public string $migrationDatePattern = '~(?<!\d)\d{10}(?!\d)~';
    protected ?ExceptionMessenger $messenger;

    public function __construct()
    {
        $this->migrations_path = $_SERVER['PWD'] . "/migrations/" ?? './';
        $this->migration_example_path = $this->migrations_path . "/migration_template.php";
        $this->messenger = new ExceptionMessenger();
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            $this->$name($arguments[0]);
        } else {
            print_r("Метод < $name > отсутствует! \n");
        }
    }

    private function create(string $migrationName)
    {
        $migrationName = "m" . time() . "_" . "migration_" . $migrationName;
        $fileName = $migrationName . ".php";
        $is_create = false;

        if (file_put_contents($this->migrations_path . $fileName, $this->migrationGenerateContent($migrationName))) {
            $is_create = true;
            print_r("Миграция $fileName успешно создана! \n");

        } 
        if (!$is_create) {
            $exception = $this->messenger->sendMessage('migration', 'create');
            $type = $exception['type'];
            $message = $exception['message'];
            print_r("{$type}: {$message} - {$fileName} . \n");
        }
        
    }

    private function drop(string $migrationName)
    {
        $fileName = $migrationName;
        $filePath = $this->migrations_path . $fileName;

        $dirScan = scandir($this->migrations_path);
        $is_delete = false;

        if ($dirScan) {
            
            foreach ($dirScan as $file) {
                if (basename($file) == $migrationName) {
                    unlink($filePath);
                    $is_delete = true;
                    print_r("Миграция $migrationName успешно удалена! \n");
                    break;
                } 
            }  
        }
        
        if(!$is_delete) {
            $exception = $this->messenger->sendMessage('migration', 'drop');
            $type = $exception['type'];
            $message = $exception['message'];
            print_r("{$type}: {$message} - {$migrationName} . \n");
        }

    }

    private function up(string $migrationName): bool
    {
        $is_up = false;
        $params = explode(':', $migrationName);
        if ($params[0] === '-all') {
            $count = isset($params[1]) ? (int) $params[1] : 0;
            return $this->upAll($count);
        }
        if ($migration = $this->getMigrationClass($migrationName)) {
            $migration->up();
            $is_up = true;
            print_r("Success UP $migrationName! \n");
        } 
        if (!$is_up) {
            $exception = $this->messenger->sendMessage('migration', 'up');
            $type = $exception['type'];
            $message = $exception['message'];
            print_r("{$type}: {$message} - {$migrationName} . \n");
        }

        return true;
    }

    private function upAll($count = 0): bool
    {
        $searchMigrations = $this->searchMigrations();
        $this->sortMigrations($searchMigrations);
        $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);
        $is_upAll = false;

        foreach ($searchMigrations as $migration) {

            if ($migrationClass = $this->createMigrationClass($migration)) {
                $migrationClass->up();
                $is_upAll = true;
                print_r("Success UP $migration! \n");
            }       
            if(!$is_upAll) {
                $exception = $this->messenger->sendMessage('migration', 'up');
                $type = $exception['type'];
                $message = $exception['message'];
                print_r("{$type}: {$message} - {$migration} . \n");
            }     
        }
        
        return true;
    }

    private function down(string $migrationName): bool
    {
        $params = explode(':', $migrationName);
        $is_down = false;

        if ($params[0] === '-all') {
            $count = isset($params[1]) ? (int) $params[1] : 0;
            return $this->downAll($count);
        }
        if ($migration = $this->getMigrationClass($migrationName)) {
            $migration->down();
            $is_down = true;
            print_r("Success DOWN $migrationName! \n");
        }
        if (!$is_down) {
            $exception = $this->messenger->sendMessage('migration', 'up');
            $type = $exception['type'];
            $message = $exception['message'];
            print_r("{$type}: {$message} - {$migrationName} . \n");
        }

        return true;
    }

    private function downAll($count = 0): bool
    {
        $searchMigrations = $this->searchMigrations();
        $this->sortMigrations($searchMigrations);
        $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);
        $searchMigrations = array_reverse($searchMigrations);
        $is_downAll = false;

        foreach ($searchMigrations as $migration) {
            if ($migrationClass = $this->createMigrationClass($migration)) {
                $migrationClass->down();
                $is_downAll = true;
                print_r("Success DOWN $migration! \n");
            }
            if(!$is_downAll) {
                $exception = $this->messenger->sendMessage('migration', 'up');
                $type = $exception['type'];
                $message = $exception['message'];
                print_r("{$type}: {$message} - {$migration} . \n");
            }     

        }

        return true;
    }

    private function migrationSliceOffset(int $count, array $migrations): array
    {
        $offset = ($count == 0 || $count > count($migrations)) ? 0 : count($migrations) - $count;
        return array_slice($migrations, $offset);
    }

    private function getMigrationClass(string $migrationName)
    {
        $dirScan = scandir($this->migrations_path);
        foreach ($dirScan as $file) {
            if (basename($file) == $migrationName) {
                return $this->createMigrationClass($migrationName);
            }
        }
        return false;
    }

    private function createMigrationClass($migrationName)
    {
        $migrationName = explode('.', $migrationName)[0];
        $class = "app\\database\\migrations\\$migrationName";
        if ($migration = new $class()) {
            return $migration;
        } 
        return false;
    }

    private function migrationGenerateContent(string $migrationName)
    {
        $example = file_get_contents($this->migration_example_path);
        return str_replace('MIGRATION_NAME', $migrationName, $example);
    }

    private function sortMigrations(array &$dirScan): void
    {       
        asort($dirScan);
    }

    private function searchMigrations(): array
    {
        return array_filter(scandir($this->migrations_path), function ($filename) {
            return preg_match($this->migrationDatePattern, $filename);
        });
    }

}