<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";


$db = new \app\services\DataBase();
$allTest = $db->queryOne("SELECT * FROM test", []);
$allTest2 = $db->queryAll("SELECT * FROM test WHERE id = :id", ['id' => 2]);

var_dump($allTest);
var_dump($allTest2);


