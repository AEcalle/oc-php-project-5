<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Form\Form;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class UserController extends AbstractController
{
    public function users(): Response
    {
        $this->checkAuth('admin');

        $users = $this->userRepository->findAll();

        return $this->render('back/users.html.twig',
            [
                'users'=>$users,
            ]
        ); 
    }

    public function updateUser(int $id): Response
    {   
        $this->checkAuth('admin');

        $user = $this->userRepository->find($id);

        $form = new Form($user,'User');

        $user = $form->handleRequest($this->request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->update($user);

            $this->session->getFlashBag()->add('success','Utilisateur modifié !');
            return $this->redirect('users');
        }

        return $this->render('back/updateUser.html.twig',
            [
                'form' => $form,
                'user' => $user,
            ]
        );
    }

    public function deleteUser(int $id, string $token): RedirectResponse
    {
        $this->checkAuth('admin');

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('User_token',$token);

        if ($tokenCSRFManager->verifToken('User', $this->request)){
            $this->userRepository->delete($id);
            $this->session->getFlashBag()->add('success','Utilisateur supprimé !');
        }

        return $this->redirect('users');
    }
}
