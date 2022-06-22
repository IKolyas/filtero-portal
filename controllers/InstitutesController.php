<?php

namespace app\controllers;

use app\models\Institute;

class institutesController extends AbstractController
{
    public function actionIndex()
    {
        $institutes = Institute::findAll();
        
        if($institutes) { 
            echo $this->render('institutes.index', ['institutes' => $institutes]);
        } else {
            $exception = $this->messenger->sendMessage('database', 'connection');
            echo $this->render('exceptions.index', ['type' => $exception['type'], 'message' => $exception['message']]);
        }
        
    }
}
