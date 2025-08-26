<?php

declare(strict_types=1);

namespace App\Items\Domain\Dtos\ItemDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<ItemDto>
 */
final class ItemDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<ItemDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
