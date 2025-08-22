<?php

declare(strict_types=1);

namespace App\Shared\Dtos\EmptyDto;

use App\Shared\Collection\CollectionTrait;
use App\Shared\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<object>
 */
final class EmptyDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<object> */
    use CollectionTrait;

    public function __construct()
    {
        $this::createEmpty();
    }
}
