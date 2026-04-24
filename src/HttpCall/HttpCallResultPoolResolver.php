<?php

declare(strict_types=1);

namespace Behatch\HttpCall;

use ReflectionClass;
use Behat\Behat\Context\Argument\ArgumentResolver;

class HttpCallResultPoolResolver implements ArgumentResolver
{
    private array $dependencies = [];

    public function __construct(/* ... */)
    {
        foreach (func_get_args() as $param) {
            $this->dependencies[$param::class] = $param;
        }
    }

    public function resolveArguments(ReflectionClass $classReflection, array $arguments)
    {
        $constructor = $classReflection->getConstructor();
        if ($constructor !== null) {
            $parameters = $constructor->getParameters();
            foreach ($parameters as $parameter) {
                if (
                    $parameter->getClass() instanceof ReflectionClass
                    && isset($this->dependencies[$parameter->getClass()->name])
                ) {
                    $arguments[$parameter->name] = $this->dependencies[$parameter->getClass()->name];
                }
            }
        }
        return $arguments;
    }
}
