<?php

namespace app\controllers;

class ErrorController extends AbstractController
{

    protected string $defaultAction = 'errorValidate';

    public function actionErrorValidate()
    {
        echo $this->render('404.html.twig');
    }

}