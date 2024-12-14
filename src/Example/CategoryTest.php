<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Example;

use Xpat\ApiTest\Attribute\Test;
use Xpat\ApiTest\Expectation\FieldEqualityExpectation;
use Xpat\ApiTest\Expectation\StatusCodeExpectation;
use Xpat\ApiTest\Test\ApiTest;
use Xpat\ApiTest\Test\ApiTestInterface;
use Xpat\ApiTest\Test\TestCase;
use Xpat\Http\Request\Get;
use Xpat\Http\Request\Headers;
use Xpat\Http\Request\Url;

final class CategoryTest extends TestCase
{
    #[Test]
    public function expenseCategories(): ApiTestInterface
    {
        return new ApiTest(
            new Get(
                new Url(
                    'http://164.92.239.228',
                    8080,
                    '/expense-categories'
                ),
                new Headers([
                    'Accept' => 'application/json',
                ])
            ),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    '0.name',
                    'Education'
                ),
            ]
        );
    }

    #[Test]
    public function someTest(): ApiTestInterface
    {
        return new ApiTest(
            new Get(
                new Url(
                    'http://164.92.239.228',
                    8080,
                    '/expense-categories'
                ),
                new Headers([
                    'Accept' => 'application/json',
                ])
            ),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    '1.name',
                    'Grocery'
                ),
            ]
        );
    }
}