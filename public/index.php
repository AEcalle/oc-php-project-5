<?php

require '../vendor/autoload.php';

use AEcalle\Oc\Php\Project5\Controller\FrontController;
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
$router->post('/post/:id-:slug','FrontController#post','post')->width('id','[0-9]+')->width('slug','[0-9a-z\-]+');
$router->get('/login','FrontController#login','login');
$router->post('/login','FrontController#login','login');
$router->get('/legal',function()
{
    echo 'Mentions légales';
}
);
$router->get('/createPost','BackController#createPost','createPost');
$router->get('/createUser','BackController#createUser','createUser');
$router->post('/createPost','BackController#createPost','createPost');
$router->post('/createUser','BackController#createUser','createUser');
$router->get('/posts','BackController#posts','posts');
$router->get('/users','BackController#users','users');
$router->get('/comments','BackController#comments','comments');
$router->post('/comments','BackController#comments','comments');
$router->get('/updatePost','BackController#updatePost','updatePost');
$router->get('/updateUser','BackController#updateUser','updateUser');
$router->post('/updatePost','BackController#updatePost','updatePost');
$router->post('/updateUser','BackController#updateUser','updateUser');


$router->run();