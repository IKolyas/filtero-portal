<?php

namespace app\controllers;


class UsersController extends AbstractController
{

    public function actionIndex()
    {
       $users = app()->user->findAll();

        echo $this->render('users\index.html.twig', ['users' => $users]);
    }

    public function actionShow($params)
    {
        if((int) $params) {
            if($user = app()->user->find($params)) {
                echo $this->render('users\show.html.twig', ['user' => $user]);
            }
        }
    }

}