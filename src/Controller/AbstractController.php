<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Repository\CommentRepository;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
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
    protected Authentication $authorization;
    protected UserRepository $userRepository;
    protected ?User $user = null;
    protected PostRepository $postRepository;
    protected CommentRepository $commentRepository;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->request = $this->router->getRequest();
        $this->session = new Session();
        $this->authorization = new Authentication();
        $this->userRepository = new UserRepository();
        $this->postRepository = new PostRepository();
        $this->commentRepository = new CommentRepository();
        $this->user = $this->getUser();
    }

    /**
     * @param <string, mixed> $context
     */

    public function render(string $view, array $context = []): Response
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);
        $twig->addGlobal('session', $this->session);
        if (isset($this->user)){
            $twig->addGlobal('userConnected', $this->user);
        }            

        return new Response($twig->render($view, $context));
    }

    /**
     * @param <string, mixed> $context
     */

    public function redirect(string $route, array $context = []): RedirectResponse
    {
        $path = $this->router->generateUrl($route, $context);
        return new RedirectResponse($path);
    }

    public function checkAuth(string $roleRequired = "author")
    {        
        if (null === $this->user){
            $this->session->getFlashBag()->add('warning','Access Denied');
            throw new AccessDeniedException();
        }

        if ($this->user->getRole() === "unauthorised" || ($roleRequired === "admin" && $this->user->getRole() === "author")){
            $this->session->getFlashBag()->add('warning','Access Denied');
            throw new AccessDeniedException();
        }
    }

    public function getUser(): ?User
    {
        if (! $this->authorization->check($this->session)){
            return null;
        }
        
        if (null === $this->user) {
            $this->user = $this->userRepository->find($this->session->get('userId'));
        }
        
        return $this->user;
    }

    
}
