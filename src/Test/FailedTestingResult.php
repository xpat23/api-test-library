<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Throwable;
use Xpat\ApiTest\FileSystem\ClassMethod;
use Xpat\Http\Response\HttpResponse;

readonly class FailedTestingResult implements TestingResult
{
    public function __construct(
        private ClassMethod $testMethod,
        private Throwable $exception,
        private string $requestUrl
    ) {
    }

    public function expectationResults(): iterable
    {
        return [];
    }

    public function testLocation(): string
    {
        return $this->testMethod->file() . '::' . $this->testMethod->method();
    }

    public function exception(): ?Throwable
    {
        return $this->exception;
    }

    public function response(): ?HttpResponse
    {
        return null;
    }

    public function requestUrl(): string
    {
        return $this->requestUrl;
    }
}