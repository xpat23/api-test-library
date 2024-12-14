<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use InvalidArgumentException;
use Xpat\Http\Json\JsonObject;
use Xpat\Http\Response\Response;

readonly class FieldExistExpectation implements ExpectationInterface
{
    public function __construct(private string $field)
    {
    }

    public function check(Response $response): void
    {
        $json = new JsonObject($response->content());

        try {
            $json->get($this->field);
        } catch (InvalidArgumentException $e) {
            throw new ExpectationFailed("Field '$this->field' not found in response content.");
        }
    }

    public function label(): string
    {
        return sprintf(
            "Field '%s' exists",
            strlen($this->field) > 15 ? substr($this->field, 0, 15) . '...' : $this->field
        );
    }
}