<?php

declare(strict_types=1);

namespace ApiTest\TestCase;

use Xpat\ApiTest\Attribute\Test;
use Xpat\ApiTest\Expectation\FieldEqualityExpectation;
use Xpat\ApiTest\Expectation\StatusCodeExpectation;
use Xpat\ApiTest\Test\ApiTest;
use Xpat\ApiTest\Test\ApiTestGroup;
use Xpat\ApiTest\Test\ApiTestInterface;
use Xpat\ApiTest\Test\TestCase;
use Xpat\Http\Json\JsonObject;
use Xpat\Http\Response\HttpResponse;
use Xpat\Http\Response\Response;

readonly class CategoryCrudTest extends TestCase
{
    #[Test]
    public function categoryCrud(): ApiTestInterface
    {
        $group = new ApiTestGroup();

        $group
            ->add(fn(): ApiTestInterface => $this->create())
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->categoriesList($response, 'znew category'))
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->getCategoryById(
                $response,
                'znew category'
            ))
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->update($response))
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->categoriesList($response, 'updated category'))
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->getCategoryById(
                $response,
                'updated category'
            )
            )
            ->add(fn(?HttpResponse $response): ApiTestInterface => $this->delete($response));

        return $group;
    }

    private function create(): ApiTestInterface
    {
        return new ApiTest(
            $this->requestFactory->post('/expense-categories', ['name' => 'znew category']),
            [
                new StatusCodeExpectation(201),
                new FieldEqualityExpectation("name", "znew category"),
            ]
        );
    }

    private function categoriesList(?HttpResponse $response, string $name): ApiTestInterface
    {
        return new ApiTest(
            $this->requestFactory->get('/expense-categories'),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    '6.name',
                    $name
                ),
            ]
        );
    }

    private function getCategoryById(HttpResponse $response, string $name): ApiTestInterface
    {
        $json = new JsonObject($response->content());

        return new ApiTest(
            $this->requestFactory->get('/expense-categories/' . $json->get('6.id')),
            [
                new StatusCodeExpectation(200),
                new FieldEqualityExpectation(
                    'name',
                    $name
                ),
            ]
        );
    }

    private function update(?Response $response): ApiTestInterface
    {
        $json = new JsonObject($response->content());
        $id = $json->get('id');

        return new ApiTest(
            $this->requestFactory->put(
                '/expense-categories/' . $id,
                [
                    'id' => $id,
                    'name' => 'updated category',
                ]
            ),
            [
                new StatusCodeExpectation(202),
                new FieldEqualityExpectation('name', 'updated category'),
            ]
        );
    }

    private function delete(?Response $response): ApiTestInterface
    {
        $json = new JsonObject($response->content());
        $id = $json->get('id');

        return new ApiTest(
            $this->requestFactory->delete(
                '/expense-categories/' . $id
            ),
            [
                new StatusCodeExpectation(202),
            ]
        );
    }
}