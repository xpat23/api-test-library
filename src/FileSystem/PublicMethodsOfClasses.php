<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

use ReflectionClass;
use ReflectionMethod;

readonly class PublicMethodsOfClasses implements Methods
{
    public function __construct(private FsClasses $fsClasses)
    {
    }

    public function all(): iterable
    {
        foreach ($this->fsClasses->all() as $className) {
            $reflection = new ReflectionClass($className);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                yield new ClassMethod(
                    $method->getDeclaringClass()->getName(),
                    $method->getName(),
                    array_map(
                        static fn($attribute) => $attribute->getName(),
                        $method->getAttributes()
                    ),
                    $method->getReturnType()?->getName() ?? 'mixed'
                );
            }
        }
    }
}