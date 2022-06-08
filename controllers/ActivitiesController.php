<?php

namespace app\controllers;

use app\services\DataBase as DataBase;


class ActivitiesController extends AbstractController
{

    public function actionIndex(): void
    {
        echo $this->render('activities.index', ['activities' => []]);
    }

}