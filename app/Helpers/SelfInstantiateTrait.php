<?php

declare(strict_types=1);

namespace App\Helpers;

trait SelfInstantiateTrait
{
    public static function create(): static
    {
        return new self();
    }
}
