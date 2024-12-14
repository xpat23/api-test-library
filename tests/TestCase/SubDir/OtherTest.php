<?php

declare(strict_types=1);

namespace ApiTest\TestCase\SubDir;

use Xpat\ApiTest\Attribute\Test;
use Xpat\ApiTest\Expectation\CallbackExpectation;
use Xpat\ApiTest\Expectation\FieldEqualityExpectation;
use Xpat\ApiTest\Expectation\StatusCodeExpectation;
use Xpat\ApiTest\Test\ApiTest;
use Xpat\ApiTest\Test\ApiTestInterface;
use Xpat\ApiTest\Test\TestCase;
use Xpat\Http\Json\JsonObject;
use Xpat\Http\Request\Get;
use Xpat\Http\Request\Headers;
use Xpat\Http\Request\Url;
use Xpat\Http\Response\Response;

readonly class OtherTest extends TestCase
{
    #[Test]
    public function testOther(): ApiTestInterface
    {
        return new ApiTest(
            $this->requestFactory->get('/products/1'),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    'price',
                    109.95
                ),
                new CallbackExpectation(
                    fn(Response $response): bool => (new JsonObject($response->content()))->get('id') === 1,
                    'ID must be 1',
                ),
            ]
        );
    }

    #[Test]
    public function testOther2(): ApiTestInterface
    {
        return new ApiTest(
            $this->requestFactory->get('/products'),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    '0.title',
                    'Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops'
                ),
            ]
        );
    }
}