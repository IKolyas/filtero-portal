<?php

namespace app\controllers;

use app\services\renderers\RendererInterface;
use app\services\ExceptionMessenger;

abstract class AbstractController
{

    protected string $defaultAction = 'index';
    protected string $defaultTemplate = 'main';
    protected string $notFound = '404';
    protected bool $useMainTemplate = true;
    protected string $action;
    protected RendererInterface $renderer;
    protected ?ExceptionMessenger $messenger;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->messenger = new ExceptionMessenger();
    }

    public function runAction($action = null, $params = []): void
    {
        $this->action = $action ?: $this->defaultAction;
        $method = "action" . ucfirst($this->action);

        if(method_exists($this, $method)) {
            $this->$method($params);
        } else {
            echo $this->renderer->render($this->notFound);
        }
    }

    protected function render(string $template, array $params = []): string
    {
        $content = $this->renderer->render($template, $params);

        if($this->useMainTemplate) {
            $auth_user = app()->session->IsAuth();
            $controller_name = app()->request->getControllerName();
            return $this->renderer->render($this->defaultTemplate, compact('content', 'auth_user', 'controller_name'));
        }
        return $content;
    }

}