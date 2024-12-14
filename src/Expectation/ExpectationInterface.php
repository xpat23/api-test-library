<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Expectation;

use Xpat\Http\Response\Response;

interface ExpectationInterface
{
    public function check(Response $response): void;

    public function label(): string;
}