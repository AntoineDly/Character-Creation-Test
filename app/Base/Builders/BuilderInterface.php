<?php

declare(strict_types=1);

namespace App\Base\Builders;

use App\Base\Dtos\DtoInterface;

interface BuilderInterface
{
    public function build(): DtoInterface;
}
