<?php

declare(strict_types=1);

namespace App\Helpers;

final readonly class ArrayHelper
{
    /**
     * @param  array<mixed, mixed>  $array
     */
    public static function isEmpty(array $array): bool
    {
        return count($array) === 0;
    }
}
