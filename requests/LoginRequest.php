<?php

namespace app\requests;

use app\base\Request;
use app\base\User;

class LoginRequest
{
      private function getUserByCookeiDb($cookie_key)
      {
            $user = User::find($cookie_key, 'cookie_key');
            
            return $user ? $user : false;

      }

      private function getCookieKeyByUser()
      {
            return isset($_COOKIE['auth']) ? $_COOKIE['auth'] : false;
      }


      public function isAuth()
      {
            app()->session();
            $is_auth = false;
            $cookie_key = $this->getCookieKeyByUser();

            if($cookie_key)
            {
                  $is_auth = $this->getUserByCookeiDb($cookie_key);
            }
            return app()->session->get('user') ?? $is_auth;

      }
      
}