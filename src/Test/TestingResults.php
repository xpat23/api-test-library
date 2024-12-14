<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

readonly class TestingResults
{
    public function __construct(private ApiTestMethods $testMethods)
    {
    }

    /**
     * @return iterable<TestingResult>
     */
    public function all(): iterable
    {
        foreach ($this->testMethods->all() as $testMethod) {
            $class = $testMethod->class();
            $method = $testMethod->method();
            /** @var ApiTestInterface $test */
            $test = (new $class())->$method();
            foreach ($test->result($testMethod) as $result) {
                yield $result;
            }
        }
    }
}