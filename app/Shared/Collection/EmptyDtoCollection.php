<?php

declare(strict_types=1);

namespace App\Shared\Collection;

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
