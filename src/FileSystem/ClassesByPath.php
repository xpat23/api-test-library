<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class ClassesByPath implements FsClasses
{
    public function __construct(private string $path)
    {
    }

    public function all(): iterable
    {
        if (! is_dir($this->path)) {
            yield (new ClassFromFile($this->path))->name();
        } else {
            $classes = new DirectoryClasses(
                new FsDirectory($this->path)
            );

            foreach ($classes->all() as $className) {
                yield $className;
            }
        }
    }
}