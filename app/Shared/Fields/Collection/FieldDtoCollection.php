<?php

declare(strict_types=1);

namespace App\Shared\Fields\Collection;

use App\Shared\Collection\CollectionInterface;
use App\Shared\Collection\CollectionTrait;
use App\Shared\Fields\Dtos\FieldDto;

/**
 * @implements CollectionInterface<FieldDto>
 */
final class FieldDtoCollection implements CollectionInterface
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
