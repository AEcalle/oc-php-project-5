<?php

namespace AEcalle\Oc\Php\Project5\Router;

class Route
{
    private $path;
    private $callable;
    private $matches;
    
    public function __construct($path,$callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }

    public function match($url)
    {         
        $url = trim($url,"/");
    
        $path = preg_replace('#:([a-zA-Z0-9_]+)+#','([^/]+)', $this->path);
        
        $regex = "#^$path$#i";
    
        if (!preg_match($regex, $url, $matches))
        {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }
}