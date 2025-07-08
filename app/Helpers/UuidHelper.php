<?php

declare(strict_types=1);

namespace App\Helpers;

abstract readonly class UuidHelper
{
    public static function isValidUuid(string $uuid): bool
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        return preg_match($pattern, $uuid) === 1;
    }
}
