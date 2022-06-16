<?php

use \app\services\MigrationService as MigrationService;
define("CONFIG", include ($_SERVER['DOCUMENT_ROOT'] . "../config.php"));


$action = $_SERVER['argv'][1] ?? false;
$migrationName = $_SERVER['argv'][2] ?? false;

if ($action && $migrationName) {

    include "../vendor/autoload.php";

    $migration = new MigrationService();

    $migration->$action($migrationName);
}
