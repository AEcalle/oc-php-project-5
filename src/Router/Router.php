<?php

namespace AEcalle\Oc\Php\Project5\Router;

use Symfony\Component\HttpFoundation\Request;

final class Router
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var array
     */
    private array $routes = [];
    
    /**
     * @var array
     */
    private array $namedRoutes = [];

    public function __construct(String $url)
    {
        $this->url = $url;
    }
    
    /**
     * get
     *
     * @param  string $path
     * @param  string,callable $callable
     * @param  string $name
     * @return Route
     */
    public function get(String $path, $callable,String $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }
    
    /**
     * post
     *
     * @param  string $path
     * @param  string,callable $callable
     * @param  string $name
     * @return Route
     */
    public function post(String $path, $callable,String $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }
        
    /**
     * add
     *
     * @param  string $path
     * @param  string, callable $callable
     * @param  string $name
     * @param  string $method
     * @return Route
     */
    private function add(String $path, $callable,String $name = null, String $method): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if($name)
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }
    
    /**
     * run
     *
     * @return string
     */
    public function run(): ?string
    {
        $request = Request::createFromGlobals();

        if (!isset($this->routes[$request->getMethod()])) 
        {
            throw new RouterException('REQUEST_METHOD doesn\'t exist');
        }

        foreach($this->routes[$request->getMethod()] as $route)
        {
            if ($route->match($this->url)){
                return $route->call();
            }
        }

        throw new RouterException('No matching routes');
    }
    
}
