<?php

namespace app\services;

class MigrationService
{

    public string $migrations_path;
    public string $migration_example_path;


    public function __construct()
    {
        $this->migrations_path = $_SERVER['PWD'] . "/migrations/" ?? './';
        $this->migration_example_path = $this->migrations_path . "/migration_template.php";
    }

    public function __call($name, $arguments)
    {
        if(method_exists($this, $name)) {
            $this->$name($arguments[0]);
        } else {
            print_r("Метод < $name > отсутствует! \n");
        }
    }

    private function create(string $migrationName)
    {
        $migrationName = "migration_" . $migrationName . "_" . time();
        $fileName = $migrationName . ".php";
        file_put_contents($this->migrations_path . $fileName, $this->migrationGenerateContent($migrationName));

        print_r("Миграция $fileName успешно создана! \n");
    }

    private function drop(string $migrationName)
    {
        $fileName = $migrationName;
        $filePath = $this->migrations_path . $fileName;

        $dirScan = scandir($this->migrations_path);

        foreach ($dirScan as $file) {
            if (basename($file) == $migrationName) {
                unlink($filePath);
                print_r("Миграция $migrationName успешно удалена! \n");
            }
        }
    }

    private function up(string $migrationName)
    {

        if($migration = $this->getMigrationClass($migrationName)) {
            $migration->up();
            print_r("Success UP $migrationName! \n");
        }
    }

    private function down(string $migrationName)
    {
        if($migration = $this->getMigrationClass($migrationName)) {
            $migration->down();
            print_r("Success DOWN $migrationName! \n");
        }
    }

    private function getMigrationClass(string $migrationName)
    {
        $dirScan = scandir($this->migrations_path);
        foreach ($dirScan as $file) {
            if (basename($file) == $migrationName) {
                $migrationName = explode('.', $migrationName)[0];
                $class = "app\\database\\migrations\\$migrationName";
                if($migration = new $class()) return $migration;
            }
        }
        return false;
    }

    private function migrationGenerateContent(string $migrationName)
    {
        $example = file_get_contents($this->migration_example_path);
        return str_replace('MIGRATION_NAME', $migrationName, $example);
    }

}