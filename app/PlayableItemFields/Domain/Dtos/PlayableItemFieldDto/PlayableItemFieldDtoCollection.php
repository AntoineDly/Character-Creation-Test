<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<PlayableItemFieldDto>
 */
final class PlayableItemFieldDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<PlayableItemFieldDto> */
    use CollectionTrait;
}
