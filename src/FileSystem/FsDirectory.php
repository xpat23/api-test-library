<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

readonly class FsDirectory
{
    public function __construct(private string $path)
    {
    }

    /**
     * @return iterable<string>
     */
    public function files(): iterable
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                yield $file->getPathname();
            }
        }
    }
}