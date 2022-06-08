<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\models\User;

class AdminController extends AbstractController
{

    public function actionIndex()
    {
        $activities = Activity::findAll();
        $user = User::findAll()[0];
        foreach ($activities as $activity) {
            $activity->age = "С $activity->age_from по $activity->age_to";
            $activity->institute = Institute::find($activity->institute_id)->title;
            $activity->type = ActivityType::find($activity->activity_type_id)->title;
        }

        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        echo $this->render('admin.index', compact('activities', 'institutes', 'types', 'user'));
    }

    public function actionCreateActivity()
    {

        if (app()->request->isPost()) {
            if (Activity::create(app()->request->post())) {
                app()->path->redirect('/admin');
            }
        }
    }
}