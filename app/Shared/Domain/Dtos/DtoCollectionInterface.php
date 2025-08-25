<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dtos;

use App\Shared\Domain\Collection\CollectionInterface;

/**
 * @template TDtoCollectionElement
 *
 * @extends CollectionInterface<TDtoCollectionElement>
 */
interface DtoCollectionInterface extends CollectionInterface, DtoInterface
{
}
