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
            $is_remember = $post_data['remember_me'];

            if($user = $this->varification($email, $password)) {
                if($is_remember)
                {
                    $this->rememberUser($user);
                }
                app()->session->set('user', ['first_name' => $user->first_name, 'last_name' => $user->last_name]);
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

    private function varification($email, $password)  
    {

        $user = User::find($email, 'email');

        if($user && $user->password == $password) return $user;

        return false;
    }

    private function rememberUser($user)
    {
    
        $randomCookie = User::randomCookie();

        $setCookieKeyDb = User::update(['id' => $user->id, 'cookie_key' => $randomCookie]);

        if($setCookieKeyDb) {
            app()->session->setCookie('auth', $randomCookie);
        } 

    }

    public function actionConfirmEmail()
    {
        echo $this->render('auth.confirmEmail');
    }

}