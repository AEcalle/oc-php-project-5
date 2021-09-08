<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Router\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private Router $router;
    protected Request $request;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->request = $this->router->getRequest();
    }

    /**
     * @param mixed[] $context
     */

    public function render(string $view, array $context = []): Response
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);

        return new Response($twig->render($view, $context));
    }

    /**
     * @param string[] $context
     */

    public function redirect(string $route, array $context = []): RedirectResponse
    {
        $path = $this->router->generateUrl($route, $context);
        return new RedirectResponse($path);
    }
}
