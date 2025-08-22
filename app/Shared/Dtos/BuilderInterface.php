<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

interface BuilderInterface
{
    public function build(): DtoInterface;
}
