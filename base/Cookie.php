<?php

namespace app\base;

class Cookie
{
      public function getCookie(string $key)
      {
          return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
      }
  
      // TODO: add time to config 
      public function setCookie(string $key, $value, $time = '2000'): void
      {
          setcookie($key, $value, time() + $time, '/');   
      }

      public function getUserByCookeiDb($cookie_key)
      {
            $user = app()->user::find($cookie_key, 'cookie_key');
            
            return $user ? $user : false;

      }
}