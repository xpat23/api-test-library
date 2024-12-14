<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Xpat\ApiTest\FileSystem\ClassMethod;

interface ApiTestInterface
{
    /**
     * @return iterable<TestingResult>
     */
    public function result(ClassMethod $method): iterable;
}