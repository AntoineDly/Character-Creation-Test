<?php

declare(strict_types=1);

namespace App\Base\Queries;

use App\Base\Dtos\DtoInterface;

interface QueryInterface
{
    /** @return DtoInterface|DtoInterface[] */
    public function get(): DtoInterface|array;
}
