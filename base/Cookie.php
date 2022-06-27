<?php

namespace app\base;

class Cookie
{
      public function getCookie(string $key)
      {
          return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
      }
  
      public function setCookie(string $key, $value): void
      {
            setcookie($key, $value, time() + app()->getConfig()['cookie_time'], '/');   
      }

      public function getUserByCookeiDb($cookie_key)
      {
            $user = app()->user::find($cookie_key, 'cookie_key');
            
            return $user ? $user : false;
      }

      public function exists($key)
      {
            return isset($_COOKIE[$key]);
      }
}