<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class DirectoryClasses implements FsClasses
{
    public function __construct(private FsDirectory $directory)
    {
    }

    public function all(): iterable
    {
        foreach ($this->directory->files() as $file) {
            $className = (new ClassFromFile($file))->name();
            if ($className) {
                yield $className;
            }
        }
    }
}