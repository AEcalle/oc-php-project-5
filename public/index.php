<?php

require 'vendor/autoload.php';

use AEcalle\Oc\Php\Project5\Router;

$router = new Router($_GET['url']);

$router->get('/posts',function(){echo 'Tous les articles';});
$router->get('/posts/:id',function($id){echo 'Afficher l\'article '. $id;});
$router->post('/posts/:id',function($id){echo 'Poster pour l\'article '. $id;});