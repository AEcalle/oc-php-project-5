<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class BackController extends AbstractController
{      
    public function createPost(): Response
    {
        if (!$this->checkAuth())
            return $this->redirect('login'); 
        
        return $this->render('back/createPost.html.twig');
    }
}