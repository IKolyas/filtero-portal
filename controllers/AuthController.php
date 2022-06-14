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

            $post_data = app()->request->post();
            $email = $post_data['email'];
            $password = $post_data['password'];

            if($this->varification($email, $password)) {
                app()->path->redirect('/activities');
            } else {
                echo $this->render('auth.login', ['error' => 'Пароль или логин неверный!']);
            }
        } else {
            echo $this->render('auth.login');
        }

    }

    public function actionRegistration()
    {
        $is_post = app()->request->isPost();
        $request = new RegistrationRequest();

        
        if($is_post && $fields = $request->validate()) {

            unset($fields['password_r']);

            if($this->createUser($fields)) {
                echo $this->render('auth.confirm_email');
            }
        } else {
            echo $this->render('auth.registration', ['errors' => $request->errors(), 'old' => $request->post()]);
        }
    }

    private function createUser($params): int
    {
        return User::create($params);
    }

    private function varification($email, $password): bool  
    {

        $user = User::find($email, 'email');

        if($user && $user->password == $password) return true;

        return false;
    
    }


    public function actionConfirmEmail()
    {
        echo $this->render('auth.confirmEmail');
    }
}