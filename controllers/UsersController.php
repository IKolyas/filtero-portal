<?php

namespace app\controllers;


use app\models\User;

class UsersController extends AbstractController
{

    public function actionIndex()
    {
        $users = User::findAll();
        if($users){
            echo $this->render('users.index', ['users' => $users]);
        } else {
            $exception = $this->messenger->sendMessage('database', 'connection');
            echo $this->render('exceptions.index', ['type' => $exception['type'], 'message' => $exception['message']]);
        }

    }

    public function actionShow($id)
    {
        if ((int)$id && $user = User::find($id)) {
            echo $this->render('users.show', ['user' => $user]);
        }
    }

}