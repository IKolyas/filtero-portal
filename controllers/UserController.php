<?php

namespace app\controllers;

use app\base\Request;
use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UserController extends AbstractController
{
    public function index()
    {

        $db = DataBase::getInstance();
        $users = $db->queryAll("SELECT * FROM users", []);

        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);

        echo $twig->render('users.html.twig', ['users' => $users]);

    }   

}