<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Closure;
use Throwable;
use Xpat\ApiTest\FileSystem\ClassMethod;

final class ApiTestGroup implements ApiTestInterface
{
    /**
     * @param iterable<Closure> $builders
     */
    private array $builders = [];

    public function result(ClassMethod $method): iterable
    {
        $previousResponse = null;
        foreach ($this->builders as $builder) {
            try {
                /** @var ApiTestInterface $test */
                $test = $builder($previousResponse);
            } catch (Throwable $e) {
                yield new FailedTestingResult($method, $e, 'unknown');
                continue;
            }

            foreach ($test->result($method) as $result) {
                if ($result->response() !== null) {
                    $previousResponse = $result->response();
                }
                yield $result;
            }
        }
    }

    public function add(Closure $testBuilder): self
    {
        $this->builders[] = $testBuilder;

        return $this;
    }

}