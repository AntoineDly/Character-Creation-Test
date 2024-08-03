<?php

declare(strict_types=1);

namespace App\Shared\Builders;

use App\Shared\Dtos\DtoInterface;

interface BuilderInterface
{
    public function build(): DtoInterface;
}
