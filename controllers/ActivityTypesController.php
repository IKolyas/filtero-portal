<?php

namespace app\controllers;

use app\services\DataBase as DataBase;

class ActivityTypesController extends AbstractController
{
    public function actionIndex()
    {
        $db = DataBase::getInstance();
        $activity_types = $db->queryAll("SELECT * FROM activity_types", []);
        echo $this->render('activityTypes\index.html.twig', ['activity_types' => $activity_types]);

    }
}