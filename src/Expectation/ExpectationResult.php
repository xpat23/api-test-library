<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

readonly class ExpectationResult
{
    public function __construct(private string $label, private bool $satisfied, private string $message)
    {
    }

    public function satisfied(): bool
    {
        return $this->satisfied;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function label(): string
    {
        return $this->label;
    }
}