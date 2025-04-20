<?php

declare(strict_types=1);

namespace App\Shared\Fields\Collection;

use App\Shared\Fields\Dtos\FieldDto;
use App\Shared\Traits\CollectionTrait;
use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @implements ArrayAccess<mixed, FieldDto>
 * @implements IteratorAggregate<FieldDto>
 */
final class FieldDtoCollection implements ArrayAccess, Countable, IteratorAggregate
{
    /** @use CollectionTrait<FieldDto> */
    use CollectionTrait;

    /** @param FieldDto[] $elements */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /** @param FieldDto[] $dtos */
    public function setFromFieldDtos(array $dtos): static
    {
        foreach ($dtos as $dto) {
            $cantBeAdd = $this->containsFieldDtoWithSameNameAndBiggerWeightOrRemoveIfLower($dto);

            if ($cantBeAdd) {
                continue;
            }

            $this->add($dto, $dto->name);
        }

        return $this;
    }

    private function containsFieldDtoWithSameNameAndBiggerWeightOrRemoveIfLower(FieldDto $dto): bool
    {
        $filteredCollection = $this->filterKey(fn (string $name) => $name === $dto->name);
        foreach ($filteredCollection as $fieldDto) {
            if ($fieldDto->typeFieldEnum->value > $dto->typeFieldEnum->value) {
                return true;
            }

            $this->offsetUnset($fieldDto);

            return false;
        }

        return false;
    }
}
