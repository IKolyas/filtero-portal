<?php

namespace app\controllers;

use app\services\ExceptionMessenger;

class ExceptionController extends AbstractController
{
    public function actionIndex()
    {
        echo $this->render('exceptions.index');
    }

}