<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos\LinkedItemDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<LinkedItemDto>
 */
final class LinkedItemDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<LinkedItemDto> */
    use CollectionTrait;
}
