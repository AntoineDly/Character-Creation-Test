<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Fields\Collection\FieldDtoCollection;

final readonly class LinkedItemForCharacterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public FieldDtoCollection $fieldDtoCollection,
    ) {
    }
}
