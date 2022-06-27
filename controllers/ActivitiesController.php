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
        $query = Activity::getActivitiesIndex();
        $types = ActivityType::findAll();

        if(Activity::isAjax()) {
            $request = new ActivitiesRequest();
            
            extract($request->filter());

            if (isset($type)) $query->type($type);
            if (isset($search)) $query->search($search);
            if (isset($order_by)) $query->orderBy($order_by);
            if (isset($order)) $query->order($order);
            $query->paginate((int) $offset, self::PAGINATE);

            $activities = $query->get();

            Activity::getActivitiesFields($activities);

            $html = Activity::renderMain($activities);
            $html_mobile = Activity::renderMobile($activities);

            
            
            header('Content-Type: application/json');

            echo json_encode(compact('html', 'html_mobile'));
            return;
        }

        $activities = $query->paginate(0,self::PAGINATE)->get();
        Activity::getActivitiesFields($activities);

        echo $this->render('activities.index', compact('activities', 'types'));
    }


}