<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\DependencyInjection;

use Psr\Container\ContainerInterface;
use ReflectionParameter;

final class Container implements ContainerInterface
{
    /**
     * @var array<object> $instances
     */
    private array $instances = [];

    /**
     * @return array<object> $instances
     */
    public function get(string $id): object
    {
        if (! $this->has($id)) {
            $reflectionClass = new \ReflectionClass($id);
            $constructor = $reflectionClass->getConstructor();

            if (null === $constructor) {
                $this->instances[$id] = $reflectionClass->newInstance();
                return $this->instances[$id];
            }
            $parameters = $constructor->getParameters();

            $this->instances[$id] = $reflectionClass->newInstanceArgs(
                array_map(fn (ReflectionParameter $parameter) => $this->get($parameter->getType()->getName()), $parameters)
            );
        }
        return $this->instances[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }
}
