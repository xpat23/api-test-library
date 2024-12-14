<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class SubClassesOf implements FsClasses
{
    public function __construct(private FsClasses $decorated, private string $class)
    {
    }

    public function all(): iterable
    {
        foreach ($this->decorated->all() as $className) {
            if (is_subclass_of($className, $this->class)) {
                yield $className;
            }
        }
    }
}