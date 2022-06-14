<?php

namespace app\requests;

use app\base\Request;
use app\models\User;

class LoginRequest extends Request
{
      private function getUserByCookeiDb($cookie_key)
      {
            $user = User::find($cookie_key, 'cookie_key');
            
            return $user ? $user : false;

      }


      public function isAuth()
      {
            $is_auth = false;
            $cookie_key = app()->session->getCookie('auth');

            if($cookie_key)
            {
                  $is_auth = $this->getUserByCookeiDb($cookie_key);
            }
            return app()->session->get('user') ?? $is_auth;

      }
      
}