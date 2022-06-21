<?php

namespace app\controllers;

class ExeptionsController extends AbstractController
{
      public function actionIndex()
      {
            echo $this->render('exceptions.index');
      }
      
}