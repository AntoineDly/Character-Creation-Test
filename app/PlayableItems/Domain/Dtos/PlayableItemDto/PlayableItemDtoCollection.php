<?php

declare(strict_types=1);

namespace App\PlayableItems\Domain\Dtos\PlayableItemDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<PlayableItemDto>
 */
final class PlayableItemDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<PlayableItemDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
