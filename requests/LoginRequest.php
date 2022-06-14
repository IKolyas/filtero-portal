<?php

namespace app\requests;

use app\base\Request;

class RememberMeRequest extends Request
{
      public function randomCookie($len)
      {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1; 

            for ($i = 0; $i < $len; $i++) {
                  $n = rand(0, $alphaLength);
                  $pass[] = $alphabet[$n];
            }

            return implode($pass);
      }

      public function setCookieUser($cookie_key, $time = 30)
      {
            setcookie('auth', $cookie_key, time()+ $time, '/');
      }

      public function setCookieKeyDb($user_id, $cookie_key)
      {
            
      }

      public function GetAuthUser($password, $email)
      {

      }
      
}