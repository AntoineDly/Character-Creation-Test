<?php

declare(strict_types=1);

namespace App\Base\Queries;

interface QueryInterface
{
    public function get(): mixed;
}
