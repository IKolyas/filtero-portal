<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";


$request = new \app\base\Request();

$controllerName = $request->getControllerName(); // Activity
$actionName = $request->getActionName(); // show
$params = $request->getParams(); // ''
$nameSpaceControllers = 'app\\controllers\\';

$className = $nameSpaceControllers . ucfirst($controllerName) . 'Controller';

if(class_exists($className)) {
    $activityController = new $className();

    $activityController->$actionName();
} else {
    echo "404 <br> Страница не найдена!";
}


