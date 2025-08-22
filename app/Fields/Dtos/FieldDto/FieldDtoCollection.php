<?php

declare(strict_types=1);

namespace App\Fields\Dtos\FieldDto;

use App\Shared\Collection\CollectionTrait;
use App\Shared\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<FieldDto>
 */
    final class FieldDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<FieldDto> */
    use CollectionTrait;

    /** @param FieldDto[] $dtos */
    public function setFromFieldDtos(array $dtos): static
    {
        foreach ($dtos as $dto) {
            if (($currentDto = $this->offsetGet($dto->name) ?? false) &&
                $currentDto->typeFieldEnum->value > $dto->typeFieldEnum->value
            ) {
                continue;
            }

            $this->offsetSet($dto->name, $dto);
        }

        return $this;
    }
}
