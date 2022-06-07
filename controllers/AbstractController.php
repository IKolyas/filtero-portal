<?php

namespace app\controllers;

use Twig\Environment,
    Twig\Loader\FilesystemLoader;

abstract class AbstractController
{

    protected string $defaultAction = 'index';
    protected string $defaultTemplate = 'main.html.twig';
    protected string $notFound = '404.html.twig';
    protected bool $useMainTemplate = true;
    protected string $action;

    public function runAction($action = null, $params = []): void
    {
        $this->action = $action ?: $this->defaultAction;
        $method = "action" . ucfirst($this->action);

        if(method_exists($this, $method)) {
            $this->$method($params);
        } else {
            echo $this->render($this->notFound);
        }
    }

    protected function render(string $template, array $params = []): string
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader);

        $content = $twig->render($template, $params);

        if($this->useMainTemplate) {

            return $twig->render($this->defaultTemplate, ['content' => $content]);
        }
        return $content;
    }

}