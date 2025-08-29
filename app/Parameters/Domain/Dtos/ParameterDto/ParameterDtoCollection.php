<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Dtos\ParameterDto;

use App\Shared\Domain\Collection\CollectionTrait;
use App\Shared\Domain\Dtos\DtoCollectionInterface;

/**
 * @implements DtoCollectionInterface<ParameterDto>
 */
final class ParameterDtoCollection implements DtoCollectionInterface
{
    /** @use CollectionTrait<ParameterDto> */
    use CollectionTrait;
}
