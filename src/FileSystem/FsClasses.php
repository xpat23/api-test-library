<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

interface FsClasses
{
    /**
     * @return iterable<string>
     */
    public function all(): iterable;
}