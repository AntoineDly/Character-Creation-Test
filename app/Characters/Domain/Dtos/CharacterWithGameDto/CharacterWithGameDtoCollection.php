<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterWithGameDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<CharacterWithGameDto>
 */
final class CharacterWithGameDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<CharacterWithGameDto> */
    use CollectionTrait;
}
