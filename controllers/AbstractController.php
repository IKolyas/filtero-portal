<?php

namespace app\controllers;

abstract class AbstractController
{
    public function __call(string $name, array $arguments)
    {
        // TODO: Implement __call() method.
        echo "404 <br> Страница не найдена!" . $name;
    }

}