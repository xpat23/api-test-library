<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class MethodsWithAttribute implements Methods
{
    public function __construct(private Methods $decorated, private string $attribute)
    {
    }

    public function all(): iterable
    {
        foreach ($this->decorated->all() as $method) {
            if ($method->hasAttribute($this->attribute)) {
                yield $method;
            }
        }
    }
}