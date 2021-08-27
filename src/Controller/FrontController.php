<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FrontController extends AbstractController
{
    public function home(): Response
    {
       
        return $this->render('front/home.html.twig');
    }

    public function testRedirect(): RedirectResponse
    {
        return $this->redirect('post',['id'=>1,'slug'=>'test']);
    }
}