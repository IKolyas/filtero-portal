<?php

namespace app\controllers;

use app\base\Request,
    app\services\DataBase as DataBase;

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