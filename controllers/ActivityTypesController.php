<?php

namespace app\controllers;

use app\base\Request;
use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ActivityTypesController extends AbstractController
{
    public function index()
    {
        $db = DataBase::getInstance();
        $activity_types = $db->queryAll("SELECT * FROM activity_tipes", []);

        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);

        echo $twig->render('activityTypes.html.twig', ['activity_types' => $activity_types]);

    }
}