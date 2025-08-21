<?php

declare(strict_types=1);

namespace App\Games\Domain\Collection;

use App\Games\Domain\Dtos\GameDto;
use App\Shared\Collection\CollectionTrait;
use App\Shared\Collection\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<GameDto>
 */
final class GameDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<GameDto> */
    use CollectionTrait;
}
