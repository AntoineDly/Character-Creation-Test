<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryDto;

use App\Shared\Collection\CollectionTrait;
use App\Shared\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<CategoryDto>
 */
final class CategoryDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<CategoryDto> */
    use CollectionTrait;
}
