<?php
namespace app\controllers;
use app\models\User;
use app\requests\RegistrationRequest;

class AuthController extends AbstractController
{

    protected string $defaultAction = 'login';

    public function actionLogin()
    {
        $is_post = app()->request->isPost();
        if($is_post) {
            $email = app()->request->post('email');
            $password = app()->request->post('password');
            echo "$email <br> $password"; //go to admin

        } else {

            echo $this->render('auth\login.html.twig');
        }

    }

    public function actionRegistration()
    {

        $is_post = app()->request->isPost();
        $request = new RegistrationRequest();

        if($is_post && $request->validate()) {
            if($this->createUser($request->validate())) {
               app()->path->redirect('/users');
            }
        } else {
            echo $this->render('auth\registration.html.twig', ['errors' => $request->errors(), 'old' => $request->post()]);
        }
    }

    private function createUser($params): int
    {
        return User::create($params);
    }


}