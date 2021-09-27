<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Repository\UserRepository;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{
    public function users(UserRepository $userRepository): Response
    {
        $this->checkAuth('admin');

        $users = $userRepository->findAll();

        return $this->render(
            'back/users.html.twig',
            [
                'users' => $users,
            ]
        );
    }

    public function updateUser(string $id, UserRepository $userRepository): Response
    {
        $this->checkAuth('admin');

        $user = $userRepository->find((int) $id);

        $isFormHandled = $this->handleform(
            'User',
            $user,
            [],
            [$userRepository,'update'],
            'Utilisateur modifié !'
        );

        if ($isFormHandled) {
            return $this->redirect('updateUser', ['id' => $id]);
        }

        return $this->render(
            'back/updateUser.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    public function deleteUser(string $id, string $token, UserRepository $userRepository): RedirectResponse
    {
        $this->checkAuth('admin');

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('User_token', $token);

        if ($tokenCSRFManager->verifToken('User', $this->request)) {
            $userRepository->delete((int) $id);
            $this->session
                ->getFlashBag()->add('success', 'Utilisateur supprimé !');
        }

        return $this->redirect('users');
    }
}
