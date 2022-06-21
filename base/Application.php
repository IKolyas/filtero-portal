<?php

namespace app\base;

use app\traits\SingleTone;
use app\services\Exceptions;

/**
 * @property $components
 * @property mixed|object|null $request
 */
class Application
{
    use SingleTone;

    protected ComponentsFactory $componentsFactory;
    protected array $config;
    protected $components;

    public function run(array $config)
    {
        $this->componentsFactory = new ComponentsFactory();
        $this->config = $config;
        $controllerName = $this->request->getControllerName() ?: $this->config['default_controller'];
        $params = $this->request->isPost() ? $this->request->post() : $this->request->getParams();
        $actionName = $this->request->getActionName();

        //      Получаем имя класса контроллера с пространством имён
        
        $controllerClass = $this->config['controller_namespace'] . ucfirst($controllerName) . "Controller";
        
        //        TODO: else Exception 404
        //        Если класс найден, попытка вызвать у класса соответствующий метод
        if (class_exists($controllerClass)) {
            //            TODO: Добавить тип renderer в конструктор
            $controller = new $controllerClass($this->renderer);
            $controller->runAction($actionName, $params);
        } else {
            $exception = new Exceptions();
            $exception->errorHandler(4, 'test');
            //$this->path->redirect('notFound');
        }
    }


    public function __get($name)
    {
//        Если не найден компонент, проверяем есть ли он в конфиге, создаём его через фабрику и помещаем в $this->components

        if (is_null($this->components) || empty($this->components[$name])) {
            if ($params = $this->config['components'][$name]) {
                $this->components[$name] = $this->componentsFactory->createComponent($name, $params);
            } else {
                // throw new \Exception("Не найдена конфигурация для компонента {$name}");
                $exception = new Exceptions();
                $exception->displayError(4, 'test');
            }
        }
        return $this->components[$name];
    }

    public function getConfig(): array
    {
        return $this->config;
    }


}