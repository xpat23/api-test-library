<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Throwable;
use Xpat\ApiTest\FileSystem\ClassMethod;
use Xpat\Http\Request\HttpRequest;

readonly class ApiTest implements ApiTestInterface
{
    public function __construct(
        private HttpRequest $request,
        private array $expectations
    ) {
    }

    public function result(ClassMethod $method): iterable
    {
        try {
            yield new ExecutedTestingResult(
                $method,
                $this->expectations,
                $this->request->execute(),
                $this->request->url()
            );
        } catch (Throwable $e) {
            yield new FailedTestingResult($method, $e, $this->request->url());
        }
    }
}