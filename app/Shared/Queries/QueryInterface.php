<?php

declare(strict_types=1);

namespace App\Shared\Queries;

use App\Shared\Dtos\DtoInterface;

interface QueryInterface
{
    /** @return DtoInterface|DtoInterface[] */
    public function get(): DtoInterface|array;
}
