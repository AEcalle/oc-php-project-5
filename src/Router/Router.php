<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Router;

use AEcalle\Oc\Php\Project5\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

final class Router
{
    private Request $request;

    /**
     * @var array<Route>
     */
    private array $routes = [];

    /**
     * @var array<Route>
     */
    private array $namedRoutes = [];

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @param  string|callable $callable
     */
    public function get(string $path, $callable, ?string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * @param  string|callable $callable
     */
    public function post(string $path, $callable, ?string $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    public function run(Container $container): ?object
    {
        if (! isset($this->routes[$this->request->getMethod()])) {
            throw new RouterException('REQUEST_METHOD doesn\'t exist');
        }

        foreach ($this->routes[$this->request->getMethod()] as $route) {
            if ($route->match($this->request->getPathInfo())) {
                try {
                    return $route->call($container);
                } catch (\Exception $e) {
                    $route = new Route('/', 'BlogController#home');
                    return $route->call($container);
                }
            }
        }

        throw new RouterException('No matching routes');
    }

    /**
     * @param  $params<string>
     */

    public function generateUrl(string $name, array $params): string
    {
        if (! isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param  string|callable $callable
     */
    private function add(
        string $path,
        $callable,
        string $name,
        string $method
    ): Route {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }
}
