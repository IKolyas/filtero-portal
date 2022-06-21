<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\requests\ActivitiesRequest;

class ActivitiesController extends AbstractController
{

    protected const PAGINATE = 10;
    protected const CURRENT_ITEM = 0;

    public function actionIndex(): void
    {

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $request = new ActivitiesRequest();

            $activities = Activity::search($request->filter(), self::PAGINATE);

            $html_mobile = '';
            $html = '';
            $this->getActivitiesFields($activities);
            foreach ($activities as $activity) {
                $this->useMainTemplate = false;
                $html_mobile .= $this->render('activities.item_mobile', compact('activity'));
                $html .= $this->render('activities.item', compact('activity'));
            }
            header('Content-Type: application/json');
            echo json_encode(compact('html', 'html_mobile'));
            return;
        }
        
        $activities = Activity::getPage(self::CURRENT_ITEM, self::PAGINATE);

        $this->getActivitiesFields($activities);

        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        echo $this->render('activities.index', compact('activities', 'institutes', 'types'));
        throw new Exception("Ошибка подключения к базе данных");
    }

    private function getActivitiesFields(&$activities): void
    {
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->amountOfWeek = $activity->getAmountOfWeek();
            $activity->institute = Institute::find($activity->institute_id)->title;
            $activity->type = ActivityType::find($activity->activity_type_id)->title;
        }
    }

}