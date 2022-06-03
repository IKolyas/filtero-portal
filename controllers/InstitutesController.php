<?php

namespace app\controllers;

use app\base\Request;
use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class institutesController extends AbstractController
{
    public function index()
    {

        $db = DataBase::getInstance();
        $institutes = $db->queryAll("SELECT * FROM institutes", []);

        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);

        echo $twig->render('institutes.html.twig', ['institutes' => $institutes]);

    }
}
