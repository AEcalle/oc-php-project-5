<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Repository\UserRepository;
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
    protected UserRepository $userRepository;
    protected User $user;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->request = $this->router->getRequest();
        $this->session = new Session();
        $this->authentification = new Authentication();
        $this->userRepository = new UserRepository();
        if ($this->session->get('userId')){
            $this->user = $this->userRepository->find($this->session->get('userId'));
        }
    }

    /**
     * @param mixed[] $context
     */

    public function render(string $view, array $context = []): Response
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);
        $twig->addGlobal('session', $this->session);
        $twig->addGlobal('userConnected', $this->user);

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

    public function checkAuth(string $roleRequired = "author"): bool
    {
        try
        {
            if (!$this->authentification->check($this->session)) {                      
                throw new ControllerException("Acces Denied");
            }
                        
            if ($this->user->getRole() === "unauthorised" || ($roleRequired === "admin" && $this->user->getRole() === "author")){
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
