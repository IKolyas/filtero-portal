<?php

namespace app\controllers;

use app\services\DataBase as DataBase;


class ActivitiesController extends AbstractController
{

    public function actionIndex(): void
    {
        $db = DataBase::getInstance();
        $activities = $db->queryAll("SELECT * FROM activities", []);

        echo $this->render('activities\index.html.twig', ['activities' => $activities]);
    }

}