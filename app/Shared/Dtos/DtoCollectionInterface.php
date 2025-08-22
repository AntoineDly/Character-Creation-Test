<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

use App\Shared\Collection\CollectionInterface;

/**
 * @template TDtoCollectionElement
 *
 * @extends CollectionInterface<TDtoCollectionElement>
 */
interface DtoCollectionInterface extends CollectionInterface, DtoInterface
{
}
