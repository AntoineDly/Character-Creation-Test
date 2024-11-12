<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class DefaultItemFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}