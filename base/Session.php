<?php

namespace app\base;

class Session
{

    public function __construct()
    {
        session_start();
    }

    public function get(string $key)
    {
        return $this->exists($key) ? $_SESSION[$key] : null;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        session_destroy();
    }

    public function isAuth()
      {
            $is_auth = false;
            $cookie_key = app()->cookie->getCookie('auth');

            if($cookie_key)
            {
                  $is_auth = app()->cookie->getUserByCookeiDb($cookie_key);
            }

            return $this->get('user') ?? $is_auth;

      }

}