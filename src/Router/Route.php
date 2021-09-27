<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Router;

use AEcalle\Oc\Php\Project5\DependencyInjection\Container;

final class Route
{
    private string $path;

    /**
     * @var string|callable
     */
    private $callable;

    /**
     * @var array<string>
     */
    private array $matches = [];

    /**
     * @var array<string>
     */
    private array $paramsRegex = [];

    /**
     * @var string|callable
     */
    public function __construct(string $path, $callable)
    {
        $this->path = $path;
        $this->callable = $callable;
    }

    public function width(string $param, string $regex): self
    {
        $this->paramsRegex[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match(string $url): bool
    {
        $path = preg_replace_callback(
            '#:([a-zA-Z0-9_]+)+#',
            [$this,'paramMatch'],
            $this->path
        );

        $regex = "#^{$path}$#i";

        if (! preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    public function call(Container $container): ?object
    {
        $params = explode('#', $this->callable);
        $controllerName = 'AEcalle\Oc\Php\Project5\Controller\\'.$params[0];
        $controller = $container->get($controllerName);
        $reflectionClass = new \ReflectionClass($controller);
        $method = $params[1];
        $methodParameters = $reflectionClass->getMethod($method)->getParameters();

        foreach ($methodParameters as $parameter) {
            if (preg_match('#AEcalle#', $parameter->getType()->getName())) {
                $this->matches[] = $container->get($parameter->getType()->getName());
            }
        }
        return $controller->$method(...$this->matches)
            ->send();
    }

    /**
     * @param  $params<string>
     */

    public function getUrl(array $params): string
    {
        $path = $this->path;

        foreach ($params as $k => $v) {
            $path = str_replace(":${k}", $v, $path);
        }

        return $path;
    }

    /**
     * @param  $match<string>
     */
    private function paramMatch(array $match): string
    {
        if (isset($this->paramsRegex[$match[1]])) {
            return '('.$this->paramsRegex[$match[1]].')';
        }

        return '([^/]+)';
    }
}
