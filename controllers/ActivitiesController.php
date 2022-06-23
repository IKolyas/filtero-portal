<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\requests\ActivitiesRequest;

class ActivitiesController extends AbstractController
{

    protected const PAGINATE = 10;

    public function actionIndex(): void
    {
        $query = Activity::select([
            '
            activities.id,
            activities.title,
            activities.age_from,
            activities.age_to,
            activities.amount_of_week,
            activities.duration_time,
            activities.price,
            activities.price_month,
            activities.contacts,
            institutes.title as institute_title,
            activity_types.title as type_title
           '
        ])
            ->leftJoin('institutes', 'institute_id', 'institutes.id')
            ->leftJoin('activity_types', 'activity_type_id', 'activity_types.id');

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $request = new ActivitiesRequest();
            $activities = $query->search($request->filter(), self::PAGINATE)->get();
            $this->getActivitiesFields($activities);

            $html_mobile = '';
            $html = '';

            foreach ($activities as $activity) {
                $this->useMainTemplate = false;
                $html_mobile .= $this->render('activities.item_mobile', compact('activity'));
                $html .= $this->render('activities.item', compact('activity'));
            }

            header('Content-Type: application/json');
            echo json_encode(compact('html', 'html_mobile'));
            return;
        }

        $activities = $query->search([], self::PAGINATE)->get();
        $this->getActivitiesFields($activities);


        echo $this->render('activities.index', compact('activities'));
    }

    private function getActivitiesFields(&$activities): void
    {
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->amountOfWeek = $activity->getAmountOfWeek();
        }
    }

}