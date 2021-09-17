<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;
use AEcalle\Oc\Php\Project5\Service\MailerService;
use AEcalle\Oc\Php\Project5\Entity\Contact;
use AEcalle\Oc\Php\Project5\Entity\Comment;
use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Form\Form;

final class FrontController extends AbstractController
{
    public function home(): Response
    {
        $posts = $this->postRepository->findBy([], ['updated_at' => 'DESC' ], 0, 2);

        $form = new Form(new Contact(), 'Contact');
                    
        $contact = $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $mailerService = new MailerService();
            $mailerService->sendEmail($contact);
            $this->session->getFlashBag()->add('success', "Votre message a bien été envoyé !");
            return $this->redirect('home');
        }
        
        return $this->render('front/home.html.twig', [
            'posts' => $posts,
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    public function blog(string $page): Response
    {
        $page = intval($page);
        $index = ($page-1)*10;

        $posts = $this->postRepository->findBy([], ['updated_at' => 'DESC'], $index, 10);
        
        $nbPosts = $this->postRepository->count();
        $nbPages = intdiv($nbPosts,10) + 1;

        return $this->render('front/blog.html.twig',[
            'posts' => $posts,
            'page' => $page,
            'nbPages' => $nbPages
        ]);
    }

    public function post(int $id, string $slug): Response
    {
        $form = new Form(new Comment(),'Comment');

        $comment = $form->handleRequest($this->request);
       
        if ($form->isSubmitted() && $form->isValid())
        {
            $comment->setCreatedAt(new \DateTime());
            $comment->setPostId($id);
            $comment->setPublished(false);
            $this->commentRepository->add($comment);
            $this->session->getFlashBag()->add('success', 'Commentaire bien enregisté ! Il sera publié après validation par l\'administrateur.');   
            return $this->redirect('post', ['id' => $id , 'slug' => $slug]);
        }

        $post = $this->postRepository->find($id);
        $comments = $this->commentRepository->findBy(['post_id' => $id,'published' => 1],['created_at' => 'DESC'], 0, 50);
        
        return $this->render('front/post.html.twig',[
            'form' => $form,
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function login(): Response
    {
        $form = new Form(new User(),'Login');

        $user = $form->handleRequest($this->request);
       
        if ($form->isSubmitted() && $form->isValid())
        {
            $userInDb = $this->userRepository->findOneBy(['email' => $user->getEmail()]);

            if (!isset($userInDb))
            {
                $this->session->getFlashBag()->add('warning', 'Adresse email inconnue');   
                return $this->redirect('login'); 
            }
            
            $passwordVerify = password_verify($user->getPassword(), $userInDb->getPassword());
            
            if (!$passwordVerify)
            {
                $this->session->getFlashBag()->add('warning','Mot de passe incorrect');   
                return $this->redirect('login');
            }            
            
            $this->session->set('userId', $userInDb->getId());
            
            return $this->redirect('createPost');

        }

        return $this->render('front/login.html.twig',['form' => $form]);
    }

    public function createUser(): Response
    {
        $form = new Form(new User(),'User');

        $user = $form->handleRequest($this->request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());
            $user->setRole('unauthorised');
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $this->userRepository->add($user);

            $this->session->getFlashBag()->add('success','Inscription enregistrée !');  
            return $this->redirect('createUser');
        }

        return $this->render('front/createUser.html.twig',            
            [
                'form' => $form,                
            ]
        );
    }
    
}