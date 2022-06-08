<?php

namespace app\controllers;

use app\models\Activity;
use app\services\DataBase as DataBase;


class ActivitiesController extends AbstractController
{

    public function actionIndex(): void
    {
        $activities = Activity::findAll();
        echo $this->render('activities.index', ['activities' => $activities]);
    }

}