<?php

namespace app\base;

class Request
{

    protected string $requestSting = '';
    protected string $requestMethod;
    protected string $urlPattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<get>.*)#ui";
    protected string $controllerName;
    protected string $actionName;
    protected string $params;

    public function __construct()
    {
        $this->requestSting = $_SERVER['REQUEST_URI'];
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->parseRequest();
    }

    protected function parseRequest(): void
    {
        if (preg_match_all($this->urlPattern, $this->requestSting, $matches)) {
            $this->controllerName = $matches['controller'][0];
            $this->actionName = $matches['action'][0];
            $this->params = $matches['get'][0];
        }
    }

    public function post(string $param)
    {
        return $_POST[$param];
    }

    public function isGet(): bool
    {
        return $this->requestMethod == 'GET';
    }

    public function isPost(): bool
    {
        return $this->requestMethod == 'POST';
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getParams(): string
    {
        return $this->params;
    }
}