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
        if (file_put_contents($this->migrations_path . $fileName, $this->migrationGenerateContent($migrationName))) {
           
            print_r("Миграция $fileName успешно создана! \n");
        } else {
           print_r(implode($this->messenger->sendMessage('migration', 'create')), $fileName);
        }
        
    }

    private function drop(string $migrationName)
    {
        $fileName = $migrationName;
        $filePath = $this->migrations_path . $fileName;

        $dirScan = scandir($this->migrations_path);

        if ($dirScan) {

            foreach ($dirScan as $file) {
                if (basename($file) == $migrationName) {
                    unlink($filePath);
                    print_r("Миграция $migrationName успешно удалена! \n");
                } 
            }  
        } else {
            print_r(implode($this->messenger->sendMessage('migration', 'drop')), $migrationName);
        }

    }

    private function up(string $migrationName): bool
    {
        $params = explode(':', $migrationName);
        if ($params[0] === '-all') {
            $count = isset($params[1]) ? (int) $params[1] : 0;
            return $this->upAll($count);
        }
        if ($migration = $this->getMigrationClass($migrationName)) {
            $migration->up();
            print_r("Success UP $migrationName! \n");
        } else {
            print_r(implode($this->messenger->sendMessage('migration', 'up')), $migrationName);
        }

        return true;
    }

    private function upAll($count = 0): bool
    {
        $searchMigrations = $this->searchMigrations();
        $this->sortMigrations($searchMigrations);
        $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);

        foreach ($searchMigrations as $migration) {
            if ($migrationClass = $this->createMigrationClass($migration)) {
                $migrationClass->up();
                print_r("Success UP $migration! \n");
            } else {
                print_r(implode($this->messenger->sendMessage('migration', 'up')), $migration);
            }
        }

        return true;
    }

    private function down(string $migrationName): bool
    {
        $params = explode(':', $migrationName);

        if ($params[0] === '-all') {
            $count = isset($params[1]) ? (int) $params[1] : 0;
            return $this->downAll($count);
        }
        if ($migration = $this->getMigrationClass($migrationName)) {
            $migration->down();
            print_r("Success DOWN $migrationName! \n");
        } else {
            print_r(implode($this->messenger->sendMessage('migration', 'down')), $migrationName);
        }

        return true;
    }

    private function downAll($count = 0): bool
    {
        $searchMigrations = $this->searchMigrations();
        $this->sortMigrations($searchMigrations);
        $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);
        $searchMigrations = array_reverse($searchMigrations);

        foreach ($searchMigrations as $migration) {
            if ($migrationClass = $this->createMigrationClass($migration)) {
                $migrationClass->down();
                print_r("Success DOWN $migration! \n");
            } else {
                print_r(implode($this->messenger->sendMessage('migration', 'down')), $migration);
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