<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Form\Form;
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
    protected Request $request;
    protected Session $session;
    protected Authentication $authorization;
    protected ?User $user = null;
    private Router $router;

    public function __construct(Router $router, Authentication $authentication, UserRepository $userRepository)
    {
        $this->router = $router;
        $this->request = $this->router->getRequest();
        $this->session = new Session();
        $this->authorization = $authentication;
        $this->user = $this->getUser($userRepository);
    }

    /**
     * @param <string, mixed> $context
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
     * @param <string, mixed> $context
     */
    public function redirect(
        string $route,
        array $context = []
    ): RedirectResponse {
        $path = $this->router->generateUrl($route, $context);
        return new RedirectResponse($path);
    }

    public function checkAuth(string $roleRequired = 'author'): void
    {
        if (null === $this->user) {
            $this->session->getFlashBag()->add('warning', 'Access Denied');
            throw new AccessDeniedException();
        }

        if ($this->user->getRole() === 'unauthorised' ||
        ($roleRequired === 'admin' && $this->user->getRole() === 'author')) {
            $this->session->getFlashBag()->add('warning', 'Access Denied');
            throw new AccessDeniedException();
        }
    }

    public function getUser(UserRepository $userRepository): ?User
    {
        if (! $this->authorization->checkUserSession($this->session)) {
            return null;
        }

        if (null === $this->user) {
            $this->user = $userRepository
                ->find($this->session->get('userId'));
        }

        return $this->user;
    }

    public function handleform(
        string $formName,
        ?object $object = null,
        array $data = [],
        ?callable $callable = null,
        string $flashMessage = ''
    ): bool {
        $className = 'AEcalle\Oc\Php\Project5\Entity\\'.$formName;
        $form = new Form(new $className(), $formName);
        if (null !== $object) {
            $form = new Form($object, $formName);
        }

        $this->session->set('form', $form);

        foreach ($data as $k => $v) {
            $this->request->request->set($k, $v);
        }

        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (is_callable($callable)) {
                $callable($form->getEntity());
            }
            $this->session->getFlashBag()
                ->add(
                    'success',
                    $flashMessage
                );
            return true;
        }
        if ($form->isSubmitted()) {
            foreach ($form->getConstraintViolation() as $violation) {
                $this->session->getFlashBag()->add('warning', $violation);
            }
            return true;
        }

        return false;
    }
}
