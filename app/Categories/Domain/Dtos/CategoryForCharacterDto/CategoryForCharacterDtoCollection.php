<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryForCharacterDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<CategoryForCharacterDto>
 */
final class CategoryForCharacterDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<CategoryForCharacterDto> */
    use CollectionTrait;

    public function __construct()
    {
        self::createEmpty();
    }
}
