<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Shared\Http\Exceptions\InvalidArrayValueTypeException;

abstract readonly class ArrayHelper
{
    /** @phpstan-ignore-next-line  */
    public static function isEmpty(?array $array): bool
    {
        return count($array ?? []) === 0;
    }

    /** @phpstan-ignore-next-line  */
    public static function returnNullOrStringValueOfKey(array $array, string $key): ?string
    {
        if (! array_key_exists(key: $key, array: $array) || is_null($array[$key])) {
            return null;
        }

        $value = $array[$key];

        if (! is_string($value)) {
            throw new InvalidArrayValueTypeException($value.' should be a string, '.gettype($value).' given.');
        }

        return $value;
    }
}
