<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Xpat\ApiTest\Request\DefaultRequestFactory;
use Xpat\ApiTest\Request\RequestFactory;

readonly abstract class TestCase
{
    public function __construct(
        protected RequestFactory $requestFactory
    ) {
    }
}