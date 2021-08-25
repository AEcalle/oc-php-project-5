<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    public function render(string $view, array $context = [])
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);

        return $twig->render($view, $context);
    }
}