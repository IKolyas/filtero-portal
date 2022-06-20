<?php

namespace app\services\renderers;

interface RendererInterface
{
    public function render(string $template, array $params = []): string;
}