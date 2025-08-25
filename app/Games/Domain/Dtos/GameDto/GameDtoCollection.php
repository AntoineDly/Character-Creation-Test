<?php

declare(strict_types=1);

namespace App\Games\Domain\Dtos\GameDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<GameDto>
 */
final class GameDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<GameDto> */
    use CollectionTrait;
}
