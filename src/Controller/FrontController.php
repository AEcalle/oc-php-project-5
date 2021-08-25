<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    public function home(): Response
    {
       
        return $this->render('front/home.html.twig');
    }
}