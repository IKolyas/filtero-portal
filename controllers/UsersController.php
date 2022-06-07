<?php

namespace app\controllers;


use app\models\User;

class UsersController extends AbstractController
{

    public function actionIndex()
    {
        $users = User::findAll();
        echo $this->render('users\index.html.twig', ['users' => $users]);
    }

    public function actionShow($id)
    {
        if ((int)$id && $user = User::find($id)) {
            echo $this->render('users\show.html.twig', ['user' => $user]);
        }
    }

}