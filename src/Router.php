<?php

namespace AEcalle\Oc\Php\Project5;

class Router
{

    private $url;
    private $routes = [];
    
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable)
    {
        $route = new Route($path,$callable);
        $this->routes['GET'][] = $route;
    }

    public function post($path, $callable)
    {
        $route = new Route($path,$callable);
        $this->routes['POST'][] = $route;
    }
}