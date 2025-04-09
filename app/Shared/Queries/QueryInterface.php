<?php

declare(strict_types=1);

namespace App\Shared\Queries;

use App\Shared\Dtos\DtoInterface;

interface QueryInterface
{
    public function get(): DtoInterface;
}
