<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto;

use App\Fields\Domain\Dtos\FieldDto\FieldDtoCollection;
use App\Shared\Domain\Dtos\DtoInterface;

final readonly class LinkedItemForCharacterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public FieldDtoCollection $fieldDtoCollection,
    ) {
    }
}
