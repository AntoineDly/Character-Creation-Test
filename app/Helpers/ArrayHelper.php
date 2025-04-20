<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Shared\Exceptions\Http\InvalidArrayValueTypeException;

final readonly class ArrayHelper
{
    /** @param mixed[] $array */
    public static function isEmpty(?array $array): bool
    {
        return count($array ?? []) === 0;
    }

    /** @param mixed[] $array */
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
