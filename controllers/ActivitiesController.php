<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;


class ActivitiesController extends AbstractController
{

    protected const PAGINATE = 5;
    protected const CURRENT_ITEM = 0;

    public function actionIndex(): void
    {
        //$activities = Activity::findAll();

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $request = app()->request->getParams();
            $last_id = explode('=', $request)[1];

            $activities = Activity::getPage($last_id, self::PAGINATE);

            $html_mobile = '';
            $html = '';
            foreach ($activities as $activity) {
                $activity->age = $activity->getAgeRange();
                $activity->amountOfWeek = $activity->getAmountOfWeek();
                $activity->institute = Institute::find($activity->institute_id)->title;
                $activity->type = ActivityType::find($activity->activity_type_id)->title;

                $this->useMainTemplate = false;
                $html_mobile .= $this->render('activities.item_mobile', compact('activity'));
                $html .= $this->render('activities.item', compact('activity'));
            }
            header('Content-Type: application/json');
            echo json_encode(compact('html', 'html_mobile'));
            return;
        }
        $activities = Activity::getPage(self::CURRENT_ITEM, self::PAGINATE);


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