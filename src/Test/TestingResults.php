<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

readonly class TestingResults
{
    public function __construct(private ApiTestMethods $testMethods, private ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @return iterable<TestingResult>
     */
    public function all(): iterable
    {
        foreach ($this->testMethods->all() as $testMethod) {
            $class = $testMethod->class();
            $method = $testMethod->method();
            /** @var ApiTestInterface $test */
            $test = ($this->container->get($class))->{$method}();
            foreach ($test->result($testMethod) as $result) {
                yield $result;
            }
        }
    }
}