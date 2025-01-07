<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class ClassMethod
{
    /**
     * @param string $class
     * @param string $method
     * @param array<string> $attributes
     * @param string $returnType
     */
    public function __construct(
        private string $class,
        private string $method,
        private array $attributes,
        private string $returnType,
        private string $file
    ) {
    }

    public function class(): string
    {
        return $this->class;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function hasAttribute(string $attribute): bool
    {
        return in_array($attribute, $this->attributes, true);
    }

    public function returnType(): string
    {
        return $this->returnType;
    }

    public function file(): string
    {
        return $this->file;
    }
}