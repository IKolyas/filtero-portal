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
            
            $activities = $query;

            if (isset($type) && !is_null($type)) $activities->type($type);
            if (isset($search) && !is_null($search)) $activities->search($search);
            if (isset($order_by) && !is_null($order_by)) $activities->orderBy($order_by);
            if (isset($order) && !is_null($order)) $activities->order($order);
            if (isset($offset) && !is_null($offset)) $activities->paginate($offset, self::PAGINATE);
            
            $activities->get();

    

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