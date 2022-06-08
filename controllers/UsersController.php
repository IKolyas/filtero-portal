<?php

namespace app\controllers;


use app\models\User;

class UsersController extends AbstractController
{

    public function actionIndex()
    {
        $users = User::findAll();
        echo $this->render('users.index', ['users' => $users]);
    }

    public function actionShow($id)
    {
        if ((int)$id && $user = User::find($id)) {
            echo $this->render('users.show', ['user' => $user]);
        }
    }

}