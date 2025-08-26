<?php

declare(strict_types=1);

namespace App\ItemFields\Domain\Dtos\ItemFieldDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<ItemFieldDto>
 */
final class ItemFieldDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<ItemFieldDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
