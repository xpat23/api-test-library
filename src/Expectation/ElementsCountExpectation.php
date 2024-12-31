<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use Xpat\Http\Json\JsonObject;
use Xpat\Http\Response\Response;

final class ElementsCountExpectation implements ExpectationInterface
{

    public function __construct(private string $key, private int $count)
    {
    }

    public function check(Response $response): void
    {
        $data = new JsonObject($response->content());

        $elements = $this->key === '' ? $data->toArray() : $data->get($this->key);

        if (count($elements) !== $this->count) {
            throw new ExpectationFailed(
                sprintf(
                    'Expected "%d" elements in "%s", got "%d"',
                    $this->count,
                    $this->key === '' ? 'response' : $this->key,
                    count($elements)
                )
            );
        }
    }

    public function label(): string
    {
        return sprintf(
            'Elements count in "%s" equals "%d"',
            $this->key === '' ? 'response' : $this->key,
            $this->count
        );
    }
}