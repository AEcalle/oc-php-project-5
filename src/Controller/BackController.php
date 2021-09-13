<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Service\Authentication;
use Symfony\Component\HttpFoundation\Response;

class BackController extends AbstractController
{      
    public function createPost(): Response
    {   
        $authentification = new Authentication();
        if (!$authentification->check($this->session))
        {            
            $this->session->getFlashBag()->add('warning','Veuillez vous identifier pour accéder à cette page'); 
            return $this->redirect('login');
        }

        return $this->render('back/createPost.html.twig');
    }
}