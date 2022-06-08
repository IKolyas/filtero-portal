<?php

namespace app\services\renderers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{

    protected Environment $renderer;

    public function __construct()
    {
        $viewsDir = app()->getConfig()['views_dir'];
        $loader = new FilesystemLoader($viewsDir);
        $this->renderer = new Environment($loader);
    }

    public function render(string $template, array $params = []): string
    {
        $template = str_replace('.', '/', $template) . ".twig";
        return $this->renderer->render($template, $params);
    }
}