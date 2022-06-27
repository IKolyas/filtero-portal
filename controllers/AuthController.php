<?php

namespace app\controllers;

use app\models\User;
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

            $login = $post_data['login'];
            $password = md5($post_data['password']);
            $is_remember = $post_data['remember_me'];

            if ($user = $this->varification($login, $password)) {
                if ($is_remember) {
                    $this->rememberUser($user);
                }
                app()->session->set('user', ['login' => $user->login, 'id' => $user->id]);
                app()->path->redirect('/admin');
            } else {
                echo $this->render('auth.login', ['error' => 'Пароль или логин неверный!']);
            }
        } else {
            echo $this->render('auth.login');
        }
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
    

    private function varification($login, $password)
    {
        $user = User::find($login, 'login');

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
