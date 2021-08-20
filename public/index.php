<?php

require '../vendor/autoload.php';

use AEcalle\Oc\Php\Project5\Router\Router;

$router = new Router($_GET['url']);

$router->get('/',function(){echo 'Homepage';});
$router->get('/posts',function(){echo 'Tous les articles';});
$router->get('/posts/:id-:slug',function($id, $slug){echo 'Afficher l\'article '
    .$slug.':'. $id;})->width('id','[0-9]+')->width('slug','[0-9a-z\-]+');
$router->get('/posts/:id',function($id){echo 'Afficher l\'article '.$id;});
$router->post('/posts/:id',function($id){echo 'Poster pour l\'article '. $id;});

$router->run();