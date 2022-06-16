<?php

namespace app\controllers;

class NotFoundController extends AbstractController
{

    public function actionIndex()
    {
        echo $this->render($this->notFound);
    }
}