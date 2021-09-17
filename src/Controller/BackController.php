<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\Post;
use AEcalle\Oc\Php\Project5\Form\Form;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\Response;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class BackController extends AbstractController
{
    public function createPost(): Response
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }

        $form = new Form(new Post(),'Post');

        $post = $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setCreatedAt(new \DateTime());
            $post->setUpdatedAt(new \DateTime());
            $post->setUserId($this->session->get('userId'));

            $this->postRepository->add($post);

            $this->session->getFlashBag()->add('success','Post ajouté !');
            return $this->redirect('createPost');
        }

        return $this->render('back/createPost.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    public function posts(): Response
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }

        $posts = $this->postRepository->findBy(['user_id' => $this->user->getId()], [], 0, 50);
        
        return $this->render('back/posts.html.twig',
            [
                'posts' => $posts
            ]
        );
    }

    public function updatePost(int $id): Response
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }

        $post = $this->postRepository->find($id);
        $form = new Form($post,'Post');

        $post = $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setUpdatedAt(new \DateTime());

            $post = $this->postRepository->update($post);
            
            $this->session->getFlashBag()->add('success','Post modifié !');
            return $this->redirect('updatePost',
                [
                    'id' => $id
                ]
            );
        }

        return $this->render('back/updatePost.html.twig',
            [
                'form' => $form,
                'post' => $post,
            ]
        );
    }

    public function deletePost(int $id, string $token): RedirectResponse
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('Post_token',$token);
        
        if ($tokenCSRFManager->verifToken('Post', $this->request)){
            $this->postRepository->delete($id);
            $this->session->getFlashBag()->add('success','Post supprimé !');
        }

        return $this->redirect('posts');
    }

    public function comments(): Response
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }

        $comments = $this->commentRepository->findAll();

        return $this->render('back/comments.html.twig',
            [           
                'comments'=>$comments,
            ]
        );
    }

    public function publishComment(int $id, bool $publish): RedirectResponse
    {
        if (! $this->checkAuth()) {
            return $this->redirect('login');
        }      

        $comment = $this->commentRepository->find($id);
        $comment->setPublished($publish);
        $this->commentRepository->update($comment);

        $this->session->getFlashBag()->add('success','Commentaire mis à jour !');
        return $this->redirect('comments');
    }

    public function users(): Response
    {
        if (! $this->checkAuth("admin")) {
            return $this->redirect('login');
        }

        $users = $this->userRepository->findAll();

        return $this->render('back/users.html.twig',
            [
                'users'=>$users,
            ]
        ); 
    }

    public function updateUser(int $id): Response
    {   
        if (! $this->checkAuth("admin")) {
            return $this->redirect('login');
        }        

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
        if (! $this->checkAuth('admin')) {
            return $this->redirect('login');
        }

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('User_token',$token);

        if ($tokenCSRFManager->verifToken('User', $this->request)){
            $this->userRepository->delete($id);
            $this->session->getFlashBag()->add('success','Utilisateur supprimé !');
        }

        return $this->redirect('users');
    }
}