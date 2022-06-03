<?php

namespace app\controllers;

use app\services\DataBase as DataBase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UsersController extends AbstractController
{
    protected string $defaultTemplate = 'custom_name.html.twig';

    public function actionIndex()
    {
        $db = DataBase::getInstance();
        $users = $db->queryAll("SELECT * FROM `users`", []);

        echo $this->render('users\index.html.twig', ['users' => $users]);
    }

}