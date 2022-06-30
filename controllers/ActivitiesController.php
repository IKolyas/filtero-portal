<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\requests\ActivitiesRequest;

class ActivitiesController extends AbstractController
{

    protected const PAGINATE = 15;

    public function actionIndex(): void
    {

        $query = Activity::getActivitiesIndex();
        $types = ActivityType::findAll();
        $institutes = Institute::findAll();

        $ages = $query->getAges();
        $amount = $query->getAmount();
        $duration = $query->getDuration();
        $price = $query->getPrice();
        $price_month = $query->getPrice('month');


        if(Activity::isAjax()) {
            $request = new ActivitiesRequest();
            
            extract($request->filter());

            if (isset($type)) $query->type($type);
            if (isset($institute)) $query->institute($institute);
            if (isset($age_from) && isset($age_to)) $query->age_from($age_from, $age_to);
            if (isset($amount_from) && isset($amount_to)) $query->amount($amount_from, $amount_to);
            if (isset($duration_from) && isset($duration_to)) $query->duration($duration_from, $duration_to);
            if (isset($price_from) && isset($price_to)) $query->price($price_from, $price_to);
            if (isset($price_month_from) && isset($price_month_to)) $query->price_month($price_month_from, $price_month_to);
            if (isset($search)) $query->search($search);
            if (isset($order_by)) $query->orderBy($order_by);
            if (isset($order)) $query->order($order);
            $query->paginate((int) $offset, self::PAGINATE);

            $activities = $query->get();

            Activity::getActivitiesFields($activities);

            $html = Activity::renderMain($activities, (int) $offset);
            $html_mobile = Activity::renderMobile($activities, (int) $offset);
            
            header('Content-Type: application/json');

            echo json_encode(compact('html', 'html_mobile'));
            return;
        }

        $activities = $query->paginate(0,self::PAGINATE)->get();
        Activity::getActivitiesFields($activities);

        echo $this->render('activities.index', compact('activities', 'types', 'institutes', 'ages', 'amount', 'duration', 'price', 'price_month'));
    }


}