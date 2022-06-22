<?php

namespace app\controllers;

use app\models\ActivityType;

class ActivityTypesController extends AbstractController
{
    public function actionIndex()
    {
        $activity_types = ActivityType::findAll();        

        if($activity_types) { 
            echo $this->render('activityTypes.index', ['activity_types' => $activity_types]);
        } else {
            $exception = $this->messenger->sendMessage('database', 'connection');
            echo $this->render('exceptions.index', ['type' => $exception['type'], 'message' => $exception['message']]);
        }
        

    }
}