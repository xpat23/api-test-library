<?php

declare(strict_types=1);

namespace Xpat\ApiTest\FileSystem;

readonly class ClassFromFile
{
    public function __construct(private string $path)
    {
    }

    public function name(): ?string
    {
        $content = file_get_contents($this->path);

        $namespace = null;
        $className = null;

        $tokens = token_get_all($content);

        foreach ($tokens as $i => $iValue) {
            if ($iValue[0] === T_NAMESPACE) {
                $namespace = '';
                for ($j = $i + 1; $j < count($tokens) && $tokens[$j] !== ';' && $tokens[$j] !== '{'; $j++) {
                    $namespace .= is_array($tokens[$j]) ? $tokens[$j][1] : $tokens[$j];
                }
                $namespace = trim($namespace);
            }

            if ($iValue[0] === T_CLASS) {
                for ($j = $i + 1, $jMax = count($tokens); $j < $jMax; $j++) {
                    if ($tokens[$j][0] === T_STRING) {
                        $className = $tokens[$j][1];
                        break 2;
                    }
                }
            }
        }

        if ($namespace && $className) {
            return $namespace . '\\' . $className;
        }

        if ($className) {
            return $className;
        }

        return null;
    }
}