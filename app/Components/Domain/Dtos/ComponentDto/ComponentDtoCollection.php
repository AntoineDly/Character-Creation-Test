<?php

declare(strict_types=1);

namespace App\Components\Domain\Dtos\ComponentDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<ComponentDto>
 */
final class ComponentDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<ComponentDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
