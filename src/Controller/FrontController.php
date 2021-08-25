<?php

namespace AEcalle\Oc\Php\Project5\Controller;

class FrontController extends AbstractController
{
    public function home()
    {
       
        echo $this->render('front/home.html.twig');
    }
}