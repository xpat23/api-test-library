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
            if ($method->returnType() !== ApiTestInterface::class) {
                throw new RuntimeException(
                    sprintf(
                        'Test method must return an instance of ApiTestInterface. Method %s::%s must return an instance of %s',
                        $method->file(),
                        $method->method(),
                        ApiTestInterface::class
                    )
                );
            }

            yield $method;
        }
    }
}