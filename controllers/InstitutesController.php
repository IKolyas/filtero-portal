<?php

namespace app\controllers;

use app\services\DataBase as DataBase;

class institutesController extends AbstractController
{
    public function actionIndex()
    {

        $db = DataBase::getInstance();
        $institutes = $db->queryAll("SELECT * FROM institutes", []);
        echo $this->render('institutes\index.html.twig', ['institutes' => $institutes]);

    }
}
