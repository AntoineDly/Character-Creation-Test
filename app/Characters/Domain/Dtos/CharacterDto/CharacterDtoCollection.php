<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<CharacterDto>
 */
final class CharacterDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<CharacterDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
