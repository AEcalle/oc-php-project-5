<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;
use AEcalle\Oc\Php\Project5\Service\MailerService;
use AEcalle\Oc\Php\Project5\Entity\Contact;
use AEcalle\Oc\Php\Project5\Form\Form;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;

class FrontController extends AbstractController
{
    public function home(): Response
    {       
        // Get the latest posts
        $postRepository = new PostRepository();        
        $posts = $postRepository->findBy(0,2);
        

        //Form Contact
        $form = new Form(new Contact(),'Contact');                       
                    
        $contact = $form->handleRequest($this->request);
        $successMessage = '';
        if ($form->isSubmitted() && $form->isValid())
        {     
            //Send an email 
            $mailerService = new MailerService();        
            $mailerService->sendEmail($contact);
            $successMessage = "Votre message a bien été envoyé !";                       
        }        
      
        return $this->render('front/home.html.twig', [
            'posts'=>$posts,         
            'contact'=>$contact,    
            'form'=>$form,
            'successMessage'=>$successMessage    
        ]);
    }
    
}