<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use Xpat\Http\Response\Response;

readonly class StatusCodeExpectation implements ExpectationInterface
{
    public function __construct(private int $statusCode)
    {
    }

    public function check(Response $response): void
    {
        if ($response->statusCode() !== $this->statusCode) {
            throw new ExpectationFailed("Expected status code $this->statusCode, got {$response->statusCode()}.");
        }
    }

    public function label(): string
    {
        return "Status code is $this->statusCode";
    }
}