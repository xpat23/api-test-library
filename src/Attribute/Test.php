<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Test
{

}