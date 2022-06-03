<?php

namespace app\controllers;

use app\base\Request;
use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ActivityController extends AbstractController
{

    public function index()
    {

        $db = DataBase::getInstance();
        $activities = $db->queryAll("SELECT * FROM activities", []);

        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);

        echo $twig->render('activities.html.twig', ['activities' => $activities]);

    }

    public function show()
    {
        $params = (new Request())->getParams();
        if((int) $params) {
            echo "Я активность с id = $params";
        } else {
            echo "Aктивность не найдена";
        }
    }

}