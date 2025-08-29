<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<LinkedItemForCharacterDto>
 */
final class LinkedItemForCharacterDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<LinkedItemForCharacterDto> */
    use CollectionTrait;
}
