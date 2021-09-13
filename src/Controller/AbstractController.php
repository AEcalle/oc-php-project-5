<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Router\Router;
use AEcalle\Oc\Php\Project5\Service\Authentication;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private Router $router;
    protected Request $request;
    protected Session $session;
    protected Authentication $authentification;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->request = $this->router->getRequest();
        $this->session = new Session();
        $this->authentification = new Authentication();
    }

    /**
     * @param mixed[] $context
     */

    public function render(string $view, array $context = []): Response
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);
        $twig->addGlobal('session', $this->session);

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

    public function checkAuth(): bool
    {
        try
        {
            if (!$this->authentification->check($this->session))
            {                      
                throw new ControllerException("Acces Denied");
            }
            
            return true;
        }
        catch (ControllerException $e)
        {
            $this->session->getFlashBag()->add('warning','Message: ' .$e->getMessage()); 
            
            return false;
        } 
       
    }
    
}
