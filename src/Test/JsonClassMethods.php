<?php

declare(strict_types=1);

namespace Xpat\ApiTest\Test;

use Xpat\ApiTest\FileSystem\Methods;

readonly class JsonClassMethods
{
    public function __construct(private Methods $methods)
    {
    }

    public function json(): string
    {
        $methods = [];

        foreach ($this->methods->all() as $method) {
            $methods[] = [
                'class' => $method->class(),
                'method' => $method->method(),
                'attributes' => $method->attributes(),
                'returnType' => $method->returnType(),
                'file' => $method->file(),
            ];
        }

        return json_encode(array_values($methods), JSON_THROW_ON_ERROR);
    }
}