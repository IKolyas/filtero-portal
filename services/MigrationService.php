<?php

namespace app\services;

use app\database\AbstractMigration;
use Exception;

class MigrationService
{

    public string $migrations_path;
    public string $migration_example_path;
    public string $migrationDatePattern = '~(?<!\d)\d{10}(?!\d)~';

    public function __construct()
    {
        $this->migrations_path = $_SERVER['PWD'] . "/migrations/" ?? './';
        $this->migration_example_path = $this->migrations_path . "/migration_template.php";
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            $this->$name($arguments[0]);
        } else {
            print_r("Метод < $name > отсутствует! \n");
        }
    }

    private function showMessageMigrate(string $create = '', string $delete = '')
    {
        try
        {
            if ($create)
            {
                print_r("Миграция $create успешно создана! \n");
            } elseif ($delete)
            {
                print_r("Миграция $delete успешно удалена! \n");
            } 
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }
    } 

    private function showMessageUpDown(string $up = '', string $down = '')
    {
        try
        {
            if ($up)
            {
                print_r("Success UP $up! \n");
            } elseif ($down)
            {
                print_r("Success DOWN $down! \n");
            }
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }    
    }

    private function create(string $migrationName)
    {
        try
        {
            $migrationName = "migration_" . $migrationName . "_" . time();
            $fileName = $migrationName . ".php";
            file_put_contents($this->migrations_path . $fileName, $this->migrationGenerateContent($migrationName));
            $this->showMessageMigrate($fileName);
            //print_r("Миграция $fileName успешно создана! \n");
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }
    }

    private function drop(string $migrationName)
    {      
        try
        {
            $fileName = $migrationName;
            $filePath = $this->migrations_path . $fileName;

            $dirScan = scandir($this->migrations_path);

            foreach ($dirScan as $file) {
                if (basename($file) == $migrationName) {
                    unlink($filePath);
                    $this->showMessageMigrate('', $migrationName);
                    //print_r("Миграция $migrationName успешно удалена! \n");
                }
            }
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }    
    }

    private function up(string $migrationName): bool
    {
        try
        {
            $params = explode(':', $migrationName);
            if ($params[0] === '-all') {
                $count = (int) $params[1] ?? false;
                $this->upAll($count);
            }
            if ($migration = $this->getMigrationClass($migrationName)) {
                $migration->up();
                $this->showMessageUpDown($migrationName);
                //print_r("Success UP $migrationName! \n");
            }
            return true;
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }  
        return false; 
    }

    private function upAll($count = 0): bool
    {
        try
        {
            $searchMigrations = $this->searchMigrations();
            $this->sortMigrations($searchMigrations);
            $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);

            foreach ($searchMigrations as $migration) {
                if ($migrationClass = $this->createMigrationClass($migration)) {
                    $migrationClass->up();
                    $this->showMessageUpDown($migration);
                    //print_r("Success UP $migration! \n");
                }
            }
            return true;
        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }
        return false;  
    }

    private function down(string $migrationName): bool
    {
        try
        {
            $params = explode(':', $migrationName);

            if ($params[0] === '-all') {
                $count = $params[1] ?? false;
                $this->downAll($count);
            }
            if ($migration = $this->getMigrationClass($migrationName)) {
                $migration->down();
                $this->showMessageUpDown('', $migrationName);
                //print_r("Success DOWN $migrationName! \n");
            }
            return true;

        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }        
        return false;
    }

    private function downAll($count = 0): bool
    {
        try
        {
            $searchMigrations = $this->searchMigrations();
            $this->sortMigrations($searchMigrations);
            $searchMigrations = $this->migrationSliceOffset($count, $searchMigrations);
            $searchMigrations = array_reverse($searchMigrations);

            foreach ($searchMigrations as $migration) {
                if ($migrationClass = $this->createMigrationClass($migration)) {
                    $migrationClass->down();
                    $this->showMessageUpDown('', $migration);
                    //print_r("Success DOWN $migration! \n");
                }
            }
            return true;

        } catch (Exception $e)
        {
            print_r("Error" . $e->getMessage() . "! \n");
        }      
        return false;
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
        if ($migration = new $class()) return $migration;
        return false;
    }

    private function migrationGenerateContent(string $migrationName)
    {
        $example = file_get_contents($this->migration_example_path);
        return str_replace('MIGRATION_NAME', $migrationName, $example);
    }

    private function sortMigrations(&$dirScan): void
    {
        usort($dirScan, function ($file_a, $file_b) {
            preg_match_all($this->migrationDatePattern, $file_a, $time_a);
            preg_match_all($this->migrationDatePattern, $file_b, $time_b);
            return $time_a[0][0] <=> $time_b[0][0];
        });
    }

    private function searchMigrations(): array
    {
        return array_filter(scandir($this->migrations_path), function ($filename) {
            return preg_match($this->migrationDatePattern, $filename);
        });
    }

}