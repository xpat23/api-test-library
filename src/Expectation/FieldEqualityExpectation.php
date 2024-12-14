<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use InvalidArgumentException;
use Xpat\Http\Json\JsonObject;
use Xpat\Http\Response\Response;

readonly class FieldEqualityExpectation implements ExpectationInterface
{
    public function __construct(private string $field, private mixed $value)
    {
    }

    public function check(Response $response): void
    {
        $json = new JsonObject($response->content());

        try {
            $actual = $json->get($this->field);
        } catch (InvalidArgumentException $e) {
            throw new ExpectationFailed("Field '$this->field' not found in response content.");
        }

        if ($actual !== $this->value) {
            throw new ExpectationFailed("Expected field '$this->field' to be '$this->value', got '$actual'.");
        }
    }

    public function label(): string
    {
        return sprintf(
            "Field '%s' equals '%s'",
            strlen($this->field) > 15 ? substr($this->field, 0, 15) . '...' : $this->field,
            strlen((string)$this->value) > 15 ? substr((string)$this->value, 0, 15) . '...' : (string)$this->value
        );
    }
}