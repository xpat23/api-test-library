<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Throwable;
use Xpat\ApiTest\Expectation\ExpectationResult;
use Xpat\Http\Response\HttpResponse;

interface TestingResult
{
    /**
     * @return iterable<ExpectationResult>
     */
    public function expectationResults(): iterable;

    public function testLocation(): string;

    public function exception(): ?Throwable;

    public function response(): ?HttpResponse;

    public function requestUrl(): string;
}