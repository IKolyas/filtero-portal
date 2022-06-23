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
        $query = Activity::getActivitiesIndex([]);


        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $request = new ActivitiesRequest();

            extract($request->filter());

            $activities = $query->search($search ?? '')
                ->orderBy($order_by)
                ->order($order)
                ->paginate($offset, self::PAGINATE)
                ->get();

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

        $activities = $query->paginate(0,self::PAGINATE)->get();
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