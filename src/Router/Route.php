<?php

namespace AEcalle\Oc\Php\Project5\Router;

final class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $paramsRegex = [];
    
    public function __construct($path,$callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }

    public function width($param, $regex)
    {
        $this->paramsRegex[$param] = str_replace('(','(?:',$regex);
        return $this;
    }

    public function match($url)
    {         
        $url = trim($url,"/");
    
        $path = preg_replace_callback('#:([a-zA-Z0-9_]+)+#', [$this,'paramMatch'], $this->path);
        
        $regex = "#^$path$#i";
    
        if (!preg_match($regex, $url, $matches))
        {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    private function paramMatch($match){
        if(isset($this->paramsRegex[$match[1]]))
        {
            return '('.$this->paramsRegex[$match[1]].')';
        }
        
        return '([^/]+)';
    }

    public function call()
    {        
        if (is_string($this->callable))
        {
            $params = explode('#',$this->callable);
            $controller = 'AEcalle\Oc\Php\Project5\Controller\\'.$params[0];
            $controller = new $controller();
            return call_user_func_array([$controller,$params[1]], $this->matches);          
        }

        return call_user_func_array($this->callable,$this->matches);
    }
    
}