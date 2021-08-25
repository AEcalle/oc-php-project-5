<?php

require '../vendor/autoload.php';

use AEcalle\Oc\Php\Project5\Router\Router;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$router = new Router($request->getPathInfo());

$router->get('/','FrontController#home');
$router->get('/blog',function(){echo 'Affiche tous les articles';});
$router->get('/posts/:id-:slug',function($id,$slug)
{echo $id.' : '.$slug;},'posts.show')->width('id','[0-9]+')->width('slug','[0-9a-z\-]+');
$router->post('/posts/:id-:slug',function($id,$slug){echo 'Poster un commentaire pour l\'article '. $id;});
$router->get('/login',function(){echo 'Se connecter';});
$router->get('/legal',function(){echo 'Mentions légales';});


$router->run();