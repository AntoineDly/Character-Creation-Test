<?php

declare(strict_types=1);

namespace App\Games\Collection;

use App\Games\Dtos\GameDto;
use App\Shared\Collection\CollectionInterface;
use App\Shared\Collection\CollectionTrait;
use App\Shared\Dtos\DtoInterface;

/**
 * @implements CollectionInterface<GameDto>
 */
final class GameDtoCollection implements CollectionInterface, DtoInterface
{
    /** @use CollectionTrait<GameDto> */
    use CollectionTrait;
}
