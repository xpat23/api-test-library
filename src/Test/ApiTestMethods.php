<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use RuntimeException;
use Xpat\ApiTest\FileSystem\ClassMethod;
use Xpat\ApiTest\FileSystem\Methods;

readonly class ApiTestMethods implements Methods
{
    public function __construct(private Methods $decorated)
    {
    }

    /**
     * @return iterable<ClassMethod>
     */
    public function all(): iterable
    {
        foreach ($this->decorated->all() as $method) {
            $methodName = $method->method();
            $className = $method->class();

            if ($method->returnType() !== ApiTestInterface::class) {
                throw new RuntimeException(
                    sprintf(
                        'Test method must return an instance of ApiTestInterface. Method %s::%s must return an instance of %s',
                        $className,
                        $methodName,
                        ApiTestInterface::class
                    )
                );
            }

            yield $method;
        }
    }
}