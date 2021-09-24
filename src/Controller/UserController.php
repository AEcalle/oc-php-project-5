<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{
    public function users(): Response
    {
        $this->checkAuth('admin');

        $users = $this->userRepository->findAll();

        return $this->render(
            'back/users.html.twig',
            [
                'users' => $users,
            ]
        );
    }

    public function updateUser(int $id): Response
    {
        $this->checkAuth('admin');

        $user = $this->userRepository->find($id);

        $isFormHandled = $this->handleform(
            'User',
            $user,
            [],
            [$this->userRepository,'update'],
            'Utilisateur modifié !'
        );

        if ($isFormHandled) {
            $this->redirect('updateUser', ['id' => $id]);
        }

        return $this->render(
            'back/updateUser.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    public function deleteUser(int $id, string $token): RedirectResponse
    {
        $this->checkAuth('admin');

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('User_token', $token);

        if ($tokenCSRFManager->verifToken('User', $this->request)) {
            $this->userRepository->delete($id);
            $this->session
                ->getFlashBag()->add('success', 'Utilisateur supprimé !');
        }

        return $this->redirect('users');
    }
}
