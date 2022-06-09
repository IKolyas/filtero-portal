<?php
namespace app\controllers;
use app\models\User;
use app\requests\RegistrationRequest;
use app\services\DataBase as DataBase;


class AuthController extends AbstractController
{

    protected string $defaultAction = 'login';

    public function actionLogin()
    {

        $is_post = app()->request->isPost();
        
        if($is_post) {
            $post_data = app()->request->post();
            $email = $post_data['email'];
            $password = $post_data['password'];
            $this->varification($email, $password);
        }
        
        echo $this->render('auth.login');

        
        
    }

    public function actionRegistration()
    {
        $is_post = app()->request->isPost();
        $request = new RegistrationRequest();

        if($is_post && $request->validate()) {
            if($this->createUser($request->validate())) {
                echo $this->render('auth.confirmEmail',);

            }
        } else {
            echo $this->render('auth.registration', ['errors' => $request->errors(), 'old' => $request->post()]);
        }
    }

    private function createUser($params): int
    {
        return User::create($params);
    }

    private function varification($email, $password): void  
    {
        $db = DataBase::getInstance();
        $user_data = $db->queryOne("SELECT email, password FROM users WHERE email = :email AND password = :password" , 
        [
            ':email' => $email,
            ':password' => $password
        ]);
        
        if($user_data)
        {
            app()->path->redirect('/activities');
        } else 
        {
            echo $this->render('auth.login', ['error' => 'Пароль или логин неверный!']);
            //app()->path->redirect('/login', ['error' => 'пароль или логин неверный!']);
        }
    }


    public function actionConfirmEmail()
    {
        echo $this->render('auth.confirmEmail');
    }
}