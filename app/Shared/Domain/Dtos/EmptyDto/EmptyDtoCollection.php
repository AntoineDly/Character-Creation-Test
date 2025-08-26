<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dtos\EmptyDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<EmptyDto>
 */
final class EmptyDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<EmptyDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
