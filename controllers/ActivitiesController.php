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

        if(Activity::isAjax()) {

            $request = new ActivitiesRequest();

            extract($request->filter());

            $activities = $query->search($search ?? '')
                ->orderBy($order_by)
                ->order($order)
                ->paginate($offset, self::PAGINATE)
                ->get();

            Activity::getActivitiesFields($activities);

            $html_mobile = '';
            $html = '';

            $html = Activity::renderMain($activities, $this);
            $html_mobile = Activity::renderMobile($activities, $this);

            header('Content-Type: application/json');
            echo json_encode(compact('html', 'html_mobile'));
            return;
        }

        $activities = $query->paginate(0,self::PAGINATE)->get();
        Activity::getActivitiesFields($activities);

        echo $this->render('activities.index', compact('activities'));
    }


}