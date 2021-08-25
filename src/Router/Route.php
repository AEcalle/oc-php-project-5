<?php

namespace AEcalle\Oc\Php\Project5\Router;

final class Route
{
    /**
     * @var string
     */
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
    
    public function __construct(string $path, $callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }
    
    /**
     * width
     *
     * @param  string $param
     * @param  string $regex
     * @return $this
     */
    public function width(string $param, string $regex): self
    {
        $this->paramsRegex[$param] = str_replace('(','(?:',$regex);
        return $this;
    }
    
    /**
     * match
     *
     * @param  string $url
     * @return bool
     */
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
     * paramMatch
     *
     * @param  string[] $match
     * @return String
     */
    private function paramMatch(array $match): string
    {
        if(isset($this->paramsRegex[$match[1]]))
        {
            return '('.$this->paramsRegex[$match[1]].')';
        }
        
        return '([^/]+)';
    }
    
    /**
     * call
     *
     * @return string
     */
    public function call(): ?string
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