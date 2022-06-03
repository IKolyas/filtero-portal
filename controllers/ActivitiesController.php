<?php

namespace app\controllers;

use app\base\Request;
use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ActivitiesController extends AbstractController
{

    public function actionIndex(): void
    {
        $db = DataBase::getInstance();
        $activities = $db->queryAll("SELECT * FROM activities", []);

        echo $this->render('activities\index.html.twig', ['activities' => $activities]);
    }

    public function actionShow()
    {
        $params = (new Request())->getParams();
        if((int) $params) {
            echo "Я активность с id = $params";
        } else {
            echo "Aктивность не найдена";
        }
    }

}