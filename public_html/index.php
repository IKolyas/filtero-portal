<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use app\models\Products as Products;

//var_dump(Products::test('get method test'));
//$db = (new DataBase())::getInstance();
//
//$allTest = $db->queryOne("SELECT * FROM test  WHERE id = :id", ['id' => 2]);
//$allTest2 = $db->queryAll("SELECT * FROM test", []);
//
//$loader = new FilesystemLoader(__DIR__ . '/../templates');
//$twig = new Environment($loader);
//
//echo $twig->render('example.html.twig', ['users' => $allTest2]);

//use app\models\Products;
//use app\models\Gifts;
//
//$product = new Products('1', 'product', 5000);
//$gift = new Gifts('1', 'gift', 1000);
//
//var_dump($product->getSale());
//var_dump($gift->getSale());