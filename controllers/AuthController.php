<?php
namespace app\controllers;
use app\services\DataBase as DataBase;

class AuthController extends AbstractController
{

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

        if($is_post) {

            $name  = app()->request->post('name');
            $email = app()->request->post('email');
            $password = app()->request->post('password');

            $this->addUser($name, $email, $password);
            
        } else {
            echo $this->render('auth\registration.html.twig');
        }
        
    }

    private function addUser($name, $email, $password){
        $userRepository = new \app\models\repositories\UserRepository();
        $userRepository->add([

            'login' => 'igor',
            'is_admin' => 1,
            'name' => $name,
            'email' => $email,
            'password' => $password,          
        ]);

    }


}