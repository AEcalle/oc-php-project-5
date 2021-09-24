<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use AEcalle\Oc\Php\Project5\Router\Router;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

$dotenv = new Dotenv();
$dotenv->loadEnv('../.env');

$router = new Router(Request::createFromGlobals());

$router->get('/', 'BlogController#home', 'home');
$router->post('/', 'BlogController#home', 'home');
$router->get('/blog/:page', 'BlogController#blog', 'blog')
    ->width('page', '[0-9]+');
$router->get('/post/:id-:slug', 'BlogController#post', 'post')
    ->width('id', '[0-9]+')->width('slug', '[0-9a-z\-]+');
$router->post('/post/:id-:slug', 'BlogController#post', 'post')
    ->width('id', '[0-9]+')->width('slug', '[0-9a-z\-]+');
$router->get('/login', 'BlogController#login', 'login');
$router->post('/login', 'BlogController#login', 'login');
$router->get('/createUser', 'BlogController#createUser', 'createUser');
$router->post('/createUser', 'BlogController#createUser', 'createUser');

$router->get('/createPost', 'PostController#createPost', 'createPost');
$router->post('/createPost', 'PostController#createPost', 'createPost');
$router->get('/posts', 'PostController#posts', 'posts');
$router->get('/updatePost/:id', 'PostController#updatePost', 'updatePost')
    ->width('id', '[0-9]+');
$router->post('/updatePost/:id', 'PostController#updatePost', 'updatePost')
    ->width('id', '[0-9]+');
$router->get(
    '/deletePost/:id/:token',
    'PostController#deletePost',
    'deletePost'
)
    ->width('id', '[0-9]+')->width('token', '[a-zA-Z0-9.]+');

$router->get('/comments', 'CommentController#comments', 'comments');
$router->post('/comments', 'CommentController#comments', 'comments');
$router->get(
    '/publishComment/:id/:published',
    'CommentController#publishComment',
    'publishComment'
)

    ->width('id', '[0-9]+')->width('published', '[0-9]+');

$router->get('/users', 'UserController#users', 'users');
$router->get('/updateUser/:id', 'UserController#updateUser', 'updateUser')
    ->width('id', '[0-9]+');
$router->post('/updateUser/:id', 'UserController#updateUser', 'updateUser')
    ->width('id', '[0-9]+');
$router->get(
    '/deleteUser/:id/:token',
    'UserController#deleteUser',
    'deleteUser'
)

    ->width('id', '[0-9]+')->width('token', '[a-zA-Z0-9.]+');

$router->run();
