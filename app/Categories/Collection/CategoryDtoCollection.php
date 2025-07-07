<?php

declare(strict_types=1);

namespace App\Categories\Collection;

use App\Categories\Dtos\CategoryDto;
use App\Shared\Collection\CollectionTrait;
use App\Shared\Collection\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<CategoryDto>
 */
final class CategoryDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<CategoryDto> */
    use CollectionTrait;
}
