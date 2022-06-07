<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

define("DB_CONF", include ($_SERVER['DOCUMENT_ROOT'] . "/../config.php"));

$config = include $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";



function app() {
    return \app\base\Application::getInstance();

}
app()->run($config);

$userRepository = new \app\models\repositories\UserRepository();

//echo $userRepository->add([
//    'first_name' => 'Igor',
//    'last_name' => 'Savenok',
//    'login' => 'igor',
//    'password' => 'igor',
//    'email' => 'igor@igor.ig',
//    'is_admin' => 1,
//]);

//echo $userRepository->update([
//    'id' => 2,
//    'is_admin' => 1,
//    'email' => 'igor@mail.ru',
//]);

//echo $userRepository->delete(2);





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


