<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";


$db = new \app\services\DataBase();
$allTest = $db->queryOne("SELECT * FROM test  WHERE id = :id", ['id' => 2]);
$allTest2 = $db->queryAll("SELECT * FROM test", []);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

echo $twig->render('example.html.twig', ['users' => $allTest2]);