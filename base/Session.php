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

    public function getCookie(string $key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }

    // TODO: add time to config 
    public function setCookie(string $key, $value, $time = '2000'): void
    {
        setcookie($key, $value, time() + $time, '/');   
    }

}