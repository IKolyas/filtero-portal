<?php

namespace app\controllers;

use app\models\User;
use app\requests\RegistrationRequest;
use app\traits\RandomCookie;

class AuthController extends AbstractController
{
    use RandomCookie;

    protected string $defaultAction = 'login';

    public function actionLogin()
    {       

        $is_post = app()->request->isPost();

        if ($is_post) {

            $post_data = app()->request->post();

            $email = $post_data['email'];
            $password = md5($post_data['password']);
            $is_remember = $post_data['remember_me'];

            if ($user = $this->varification($email, $password)) {
                if ($is_remember) {

                    $this->rememberUser($user);
                }
                app()->session->set('user', $user);
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

            if(User::create($fields)) {
                
                echo $this->render('auth.confirm_email');
            }
        } else {
            echo $this->render('auth.registration', ['errors' => $request->errors(), 'old' => $request->post()]);
        }
    }

    public function actionConfirmEmail()
    {
        echo $this->render('auth.confirm_email');
    }

    public function actionLogout()
    {
        if (app()->session->exists('user')){

            app()->session->delete('user');
        }

        if (app()->cookie->exists('auth')){
            
            app()->cookie->setCookie('auth', '', time(), '/');
        }
        
        app()->path->redirect('/');
    }
    
    private function varification($email, $password)  

    {

        $user = User::find($email, 'email');

        if ($user && $user->password == $password) return $user;

        return false;
    }

    private function rememberUser($user)
    {

        $randomCookie = $this->randomCookie();

        $setCookieKeyDb = User::update(['id' => $user->id, 'cookie_key' => $randomCookie]);

        if ($setCookieKeyDb) {
            app()->cookie->setCookie('auth', $randomCookie);
        }
    }

   
}
