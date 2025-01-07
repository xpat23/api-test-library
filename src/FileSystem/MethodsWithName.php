<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class MethodsWithName implements Methods
{
    public function __construct(
        private Methods $decorated,
        private string $name
    ) {
    }

    public function all(): iterable
    {
        if (! empty($this->name)) {
            foreach ($this->decorated->all() as $method) {
                if ($method->method() === $this->name) {
                    yield $method;
                }
            }
        } else {
            yield from $this->decorated->all();
        }
    }
}