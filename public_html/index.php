<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";



use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use app\models\Products as Products;


$content = file_get_contents('../database/migrations/migration_add_user_table_1653986760.php');
var_dump(str_replace('CREATE', 'UPDATE', $content));
//
//$db = DataBase::getInstance();
//var_dump($db->queryAll("SELECT * from mysql.user;"));


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