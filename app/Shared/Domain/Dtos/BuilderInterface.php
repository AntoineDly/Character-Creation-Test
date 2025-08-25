<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dtos;

interface BuilderInterface
{
    public function build(): DtoInterface;
}
