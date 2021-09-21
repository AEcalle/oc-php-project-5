<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use AEcalle\Oc\Php\Project5\Entity\Post;
use AEcalle\Oc\Php\Project5\Form\Form;
use Cocur\Slugify\Slugify;

final class PostController extends AbstractController
{
    public function createPost(): Response
    {
        $this->checkAuth();

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
        $this->checkAuth();

        $posts = $this->postRepository->findBy(['user_id' => $this->user->getId()], [], 0, 50);
        
        return $this->render('back/posts.html.twig',
            [
                'posts' => $posts
            ]
        );
    }

    public function updatePost(int $id): Response
    {
        $this->checkAuth();

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
        $this->checkAuth();

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('Post_token',$token);
        
        if ($tokenCSRFManager->verifToken('Post', $this->request)){
            $this->postRepository->delete($id);
            $this->session->getFlashBag()->add('success','Post supprimé !');
        }

        return $this->redirect('posts');
    }
}
