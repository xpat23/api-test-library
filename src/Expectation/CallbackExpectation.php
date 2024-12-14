<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use Closure;
use Xpat\Http\Response\Response;

readonly class CallbackExpectation implements ExpectationInterface
{
    public function __construct(
        private Closure $callback,
        private string $label = "Callback checking"
    ) {
    }

    public function check(Response $response): void
    {
        $result = ($this->callback)($response);

        if ($result === false) {
            throw new ExpectationFailed('Callback returned false.');
        }
    }

    public function label(): string
    {
        return $this->label;
    }
}