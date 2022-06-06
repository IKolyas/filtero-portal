<?php
namespace app\controllers;
use app\services\DataBase as DataBase;

class logInController extends AbstractController
{

    protected string $defaultTemplate = 'logIn.html.twig';

    public function actionIndex($login, $password)
    {
        $db = DataBase::getInstance();
        $user = $db->query("SELECT * FROM `users` WHERE login = :login and password = :password", [$login, $password]);

        if ($user){
            echo $this->render('users\index.html.twig', ['users' => $user]);
        }
    }


}