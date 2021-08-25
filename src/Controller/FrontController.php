<?php

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    public function home(): Response
    {
       
        return $this->render('front/home.html.twig');
    }

    public function testRedirect(): RedirectResponse
    {
        return $this->redirect('posts.show',['id'=>1,'slug'=>'test']);
    }
}