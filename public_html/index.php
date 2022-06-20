<?php
//phpinfo();
include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

define("CONFIG", include ($_SERVER['DOCUMENT_ROOT'] . "/../config.php"));

$config = include $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";

function app() {
    return \app\base\Application::getInstance();
}
app()->run($config);

