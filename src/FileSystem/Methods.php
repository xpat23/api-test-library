<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

interface Methods
{
    /**
     * @return iterable<ClassMethod>
     */
    public function all(): iterable;
}