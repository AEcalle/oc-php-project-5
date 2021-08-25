<?php

namespace AEcalle\Oc\Php\Project5\Router;

use AEcalle\Oc\Php\Project5\Router\Router;

final class Route
{
    private string $path;

    /**
     * @var string|callable
     */
    private $callable;

    /**
     * @var string[]
     */
    private array $matches = [];
    
    /**
     * @var string[]
     */
    private array $paramsRegex = [];
    
    /**
     * @var string|callable
     */
    public function __construct(string $path, $callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }    
   
    public function width(string $param, string $regex): self
    {
        $this->paramsRegex[$param] = str_replace('(','(?:',$regex);
        return $this;
    }    
  
    public function match(string $url): bool
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
    
    /**
     *
     * @param  string[] $match
     * 
     */
    private function paramMatch(array $match): string
    {
        if(isset($this->paramsRegex[$match[1]]))
        {
            return '('.$this->paramsRegex[$match[1]].')';
        }
        
        return '([^/]+)';
    }
 
    public function call(Router $router): ?string
    {        
        if (is_string($this->callable))
        {
            $params = explode('#',$this->callable);
            $controller = 'AEcalle\Oc\Php\Project5\Controller\\'.$params[0];
            $controller = new $controller($router);
            return call_user_func_array([$controller,$params[1]], $this->matches)->send();          
        }

        return call_user_func_array($this->callable,$this->matches);
    }

    /**
     *
     * @param  string[] $params
     * 
     */

    public function getUrl(array $params)
    {
        $path = $this->path;
       
        foreach($params as $k=>$v)
        {
            $path = str_replace(":$k",$v,$path);
        }

        return $path;
    }
    
}