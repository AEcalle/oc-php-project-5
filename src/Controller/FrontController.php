<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;
use AEcalle\Oc\Php\Project5\Service\MailerService;
use AEcalle\Oc\Php\Project5\Service\ValidatorService;
use AEcalle\Oc\Php\Project5\Form\ContactForm;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;

class FrontController extends AbstractController
{
    public function home(): Response
    {   
        // Get the latest posts
        $postRepository = new PostRepository();        
        $posts = $postRepository->findBy(0,2);
        

        //Form Contact
        $form = new ContactForm();                       
                    
        $form = $form->handleRequest($this->request);
        
        if ($form->isSubmitted())
        {                     
            $tokenCSRFManager = new TokenCSRFManager();
            if ($tokenCSRFManager->verifToken('contact',$this->request))
            {             
                $isEmailCorrect = ValidatorService::isEmailCorrect($form->getEmail());

                if ($isEmailCorrect['test']){       
                    //Send an email         
                    MailerService::sendEmail($form->getEmail(),$form->getName(),$form->getMessage());
                    $form->setFlashMessage('Votre message a bien été envoyé !');
                    $form->setColorFlashMessage('success');                   
                }else{                              
                    $form->setFlashMessage($isEmailCorrect['message']);
                }
            }              
        }        
      
        return $this->render('front/home.html.twig', [
            'posts'=>$posts,         
            'form'=>$form          
        ]);
    }
    
}