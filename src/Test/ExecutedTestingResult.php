<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Throwable;
use Xpat\ApiTest\Expectation\ExpectationFailed;
use Xpat\ApiTest\Expectation\ExpectationInterface;
use Xpat\ApiTest\Expectation\ExpectationResult;
use Xpat\ApiTest\FileSystem\ClassMethod;
use Xpat\Http\Response\HttpResponse;

readonly class ExecutedTestingResult implements TestingResult
{
    /**
     * @param ClassMethod $testMethod
     * @param iterable<ExpectationInterface> $expectations
     * @param HttpResponse $response
     */
    public function __construct(
        private ClassMethod $testMethod,
        private iterable $expectations,
        private HttpResponse $response,
        private string $requestUrl
    ) {
    }

    /**
     * @return iterable<ExpectationResult>
     */
    public function expectationResults(): iterable
    {
        foreach ($this->expectations as $expectation) {
            try {
                $expectation->check($this->response);

                yield new ExpectationResult(
                    $expectation->label(),
                    true,
                    'Expectation satisfied.'
                );
            } catch (ExpectationFailed $e) {
                yield new ExpectationResult(
                    $expectation->label(),
                    false,
                    $e->getMessage()
                );
            } catch (Throwable $e) {
                yield new ExpectationResult(
                    $expectation->label(),
                    false,
                    sprintf('Unexpected error: %s', $e->getMessage())
                );
            }
        }
    }

    public function testLocation(): string
    {
        return $this->testMethod->file() . '::' . $this->testMethod->method();
    }

    public function exception(): ?Throwable
    {
        return null;
    }

    public function response(): ?HttpResponse
    {
        return $this->response;
    }

    public function requestUrl(): string
    {
        return $this->requestUrl;
    }
}