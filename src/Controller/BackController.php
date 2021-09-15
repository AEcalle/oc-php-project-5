<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\Post;
use AEcalle\Oc\Php\Project5\Form\Form;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Cocur\Slugify\Slugify;

final class BackController extends AbstractController
{
    public function createPost(): Response
    {
        if (!$this->checkAuth()) {
            return $this->redirect('login');
        }

        $postRepository = new PostRepository();

        $form = new Form(new Post(),'Post');

        $post = $form->handleRequest($this->request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setCreatedAt(new \DateTime());
            $post->setUpdatedAt(new \DateTime());
            $post->setUserId($this->session->get('userId'));

            $postRepository->add($post);
            
            $this->session->getFlashBag()->add('success','Post ajouté !');   
            return $this->redirect('createPost');
        }

        return $this->render('back/createPost.html.twig',
            [
                'form' => $form,
            ]
        );
    }
}