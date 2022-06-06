<?php

namespace app\base;

use app\traits\SingleTone;

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
        $actionName = $this->request->getActionName();

//      Получаем имя класса контроллера с пространством имён
        $controllerClass = $this->config['controller_namespace'] . ucfirst($controllerName) . "Controller";

//        TODO: else Exception 404
//        Если класс найден, попытка вызвать у класса соответствующий метод
        if (class_exists($controllerClass)) {
//            TODO: Добавить тип renderer в конструктор
            $controller = new $controllerClass();
            $controller->runAction($actionName);
        } else {
            echo "404";
        }
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __get($name)
    {
//        Если не найден компонент, проверяем есть ли он в конфиге, создаём его через фабрику и помещаем в $this->components

        if (is_null($this->components) || is_null($this->components[$name])) {
            if ($params = $this->config['components'][$name]) {
                $this->components[$name] = $this->componentsFactory->createComponent($name, $params);
            } else {
                throw new \Exception("Не найдена конфигурация для компонента {$name}");
            }
        }
        return $this->components[$name];
    }

    public function getConfig(): array
    {
        return $this->config;
    }


}