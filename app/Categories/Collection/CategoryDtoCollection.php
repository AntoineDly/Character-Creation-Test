<?php

declare(strict_types=1);

namespace App\Categories\Collection;

use App\Categories\Dtos\CategoryDto;
use App\Shared\Collection\CollectionInterface;
use App\Shared\Collection\CollectionTrait;
use App\Shared\Dtos\DtoInterface;

/**
 * @implements CollectionInterface<CategoryDto>
 */
final class CategoryDtoCollection implements CollectionInterface, DtoInterface
{
    /** @use CollectionTrait<CategoryDto> */
    use CollectionTrait;
}
