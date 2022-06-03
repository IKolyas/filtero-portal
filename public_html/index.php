<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

define("DB_CONF", include ($_SERVER['DOCUMENT_ROOT'] . "/../config.php"));

$config = include $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";

\app\base\Application::getInstance()->run($config);

//$request = new \app\base\Request();
//
//$controllerName = $request->getControllerName(); // Activity
//$actionName = $request->getActionName(); // show
//$params = $request->getParams(); // ''
//$nameSpaceControllers = 'app\\controllers\\';
//
//$className = $nameSpaceControllers . ucfirst($controllerName) . 'Controller';
//if(class_exists($className)) {
//    $controller = new $className();
//    $controller->runAction($actionName);
//} else {
//    echo "404 <br> Страница не найдена!";
//}


