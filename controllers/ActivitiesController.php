<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\models\User;


class ActivitiesController extends AbstractController
{

    public function actionIndex(): void
    {
        $activities = Activity::findAll();
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->amountOfWeek = $activity->getAmountOfWeek();
            $activity->institute = Institute::find($activity->institute_id)->title;
            $activity->type = ActivityType::find($activity->activity_type_id)->title;
        }

        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        echo $this->render('activities.index', compact('activities', 'institutes', 'types'));
    }

}