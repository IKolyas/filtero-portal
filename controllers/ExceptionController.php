<?php

namespace app\controllers;

use app\services\ExceptionMessenger;

class ExceptionController extends AbstractController
{
    public function actionIndex()
    {
        $request = app()->request->getParams();
        $params = [];
        $parseParams = explode('&', $request);
        foreach ($parseParams as $param) {
            $params[explode('=', $param)[0]] = explode('=', $param)[1];
        }

        $exception = new ExceptionMessenger();
        $message = $exception->sendMessage($params['type'], $params['action']);

        echo $this->render('exceptions.index', ['type' => $message['type'], 'message' => $message['message']]);
    }

}