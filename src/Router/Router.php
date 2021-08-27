<?php

namespace AEcalle\Oc\Php\Project5\Router;

use Symfony\Component\HttpFoundation\Request;

final class Router
{
    private string $url;

    /**
     * @var Route[]
     */
    private array $routes = [];

    /**
     * @var Route[]
     */
    private array $namedRoutes = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * 
     * @param  string|callable $callable     
     * 
     */
    public function get(string $path, $callable, string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     *
     * @param  string|callable $callable
     * 
     */
    public function post(string $path, $callable, string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     *      
     * @param  string|callable $callable
     * 
     */
    private function add(string $path, $callable, string $name = null, string $method): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(): ?string
    {
        $request = Request::createFromGlobals();

        if (!isset($this->routes[$request->getMethod()])) {
            throw new RouterException('REQUEST_METHOD doesn\'t exist');
        }

        foreach ($this->routes[$request->getMethod()] as $route) {
            if ($route->match($this->url)) {
                return $route->call($this);
            }
        }

        throw new RouterException('No matching routes');
    }

    /**
     *
     * @param  string[] $params
     * 
     */

    public function generateUrl(string $name, array $params): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
       
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
