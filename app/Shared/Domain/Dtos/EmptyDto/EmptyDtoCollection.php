<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dtos\EmptyDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;

/**
 * @implements DtoCollectionInterface<DtoInterface>
 */
final class EmptyDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<DtoInterface> */
    use CollectionTrait;
}
