<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Entity\Post;
use AEcalle\Oc\Php\Project5\Form\Form;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\Response;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    public function posts(): Response
    {
        if (!$this->checkAuth()) {
            return $this->redirect('login');
        }
        
        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();
        
        return $this->render('back/posts.html.twig',['posts'=>$posts]);
    }

    public function updatePost($id): Response
    {
        if (!$this->checkAuth()) {
            return $this->redirect('login');
        }
 
        $postRepository = new PostRepository();
        $post = $postRepository->find($id);
        $form = new Form($post,'Post');

        $post = $form->handleRequest($this->request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle()));           
            $post->setUpdatedAt(new \DateTime());         

            $post = $postRepository->update($post);
            
            $this->session->getFlashBag()->add('success','Post modifié !');   
            return $this->redirect('updatePost',['id'=>$id]);
        }        

        return $this->render('back/updatePost.html.twig',[
            'form'=>$form,
            'post'=>$post,
        ]);
    }

    public function deletePost($id,$token): RedirectResponse
    {
        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('Post_token',$token);
        
        if ($tokenCSRFManager->verifToken('Post', $this->request)){
            $postRepository = new PostRepository();
            $postRepository->delete($id);
            $this->session->getFlashBag()->add('success','Post supprimé !');
        }

        
        return $this->redirect('posts');
    }
}