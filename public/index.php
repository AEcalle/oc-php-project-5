<?php

require '../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use AEcalle\Oc\Php\Project5\Router\Router;
use Symfony\Component\HttpFoundation\Request;

$dotenv = new Dotenv();
$dotenv->loadEnv('../.env');

$router = new Router(Request::createFromGlobals());

$router->get('/','FrontController#home','home');
$router->post('/','FrontController#home','home');
$router->get('/blog/:page','FrontController#blog','blog')->width('page','[0-9]+');
$router->get('/post/:id-:slug','FrontController#post','post')->width('id','[0-9]+')->width('slug','[0-9a-z\-]+');
$router->post('/post/:id-:slug',function($id,$slug){echo 'Poster un commentaire pour l\'article '. $id;});
$router->get('/login',function(){echo 'Se connecter';});
$router->get('/legal',function(){echo 'Mentions légales';});

$router->run();