<?php

declare(strict_types=1);

namespace App\Helpers;

abstract readonly class ClassHelper
{
    /** @param class-string $class */
    public static function getShortname(string $class): string
    {
        $namespaceLastPosition = strrpos($class, '\\');

        if ($namespaceLastPosition === false) {
            return $class;
        }

        return substr($class, $namespaceLastPosition + 1);
    }
}
