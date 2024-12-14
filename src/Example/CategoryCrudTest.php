<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Example;

use Xpat\ApiTest\Attribute\Test;
use Xpat\ApiTest\Expectation\FieldEqualityExpectation;
use Xpat\ApiTest\Expectation\StatusCodeExpectation;
use Xpat\ApiTest\Test\ApiTest;
use Xpat\ApiTest\Test\ApiTestGroup;
use Xpat\ApiTest\Test\ApiTestInterface;
use Xpat\ApiTest\Test\TestCase;
use Xpat\Http\Json\JsonObject;
use Xpat\Http\Request\Get;
use Xpat\Http\Request\Headers;
use Xpat\Http\Request\Url;
use Xpat\Http\Response\HttpResponse;

final class CategoryCrudTest extends TestCase
{
    #[Test]
    public function categoryCrud(): ApiTestInterface
    {
        $group = new ApiTestGroup();

        $group
            ->add(fn() => $this->categoriesList())
            ->add(fn(?HttpResponse $response) => $this->getCategoryById($response));

        return $group;
    }

    private function categoriesList(): ApiTestInterface
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

    private function getCategoryById(HttpResponse $response): ApiTestInterface
    {
        $json = new JsonObject($response->content());

        return new ApiTest(
            new Get(
                new Url(
                    'http://164.92.239.228',
                    8080,
                    '/expense-categories/' . $json->get('2.id')
                ),
                new Headers([
                    'Accept' => 'application/json',
                ])
            ),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    'name',
                    'Travel'
                ),
            ]
        );
    }
}