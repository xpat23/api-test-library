<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use Xpat\Http\Response\Response;

readonly class ContentExpectation implements ExpectationInterface
{
    public function __construct(private string $content)
    {
    }

    public function check(Response $response): void
    {
        if ($response->content() !== $this->content) {
            throw new ExpectationFailed("Expected content '$this->content', got '{$response->content()}'.");
        }
    }

    public function label(): string
    {
        return sprintf(
            "Content equals '%s'",
            strlen($this->content) > 15 ? substr($this->content, 0, 15) . '...' : $this->content
        );
    }
}