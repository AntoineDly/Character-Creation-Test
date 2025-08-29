<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<LinkedItemFieldDto>
 */
final class LinkedItemFieldDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<LinkedItemFieldDto> */
    use CollectionTrait;
}
