<?php

declare(strict_types=1);

namespace App\ComponentFields\Domain\Dtos\ComponentFieldDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<ComponentFieldDto>
 */
final class ComponentFieldDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<ComponentFieldDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
