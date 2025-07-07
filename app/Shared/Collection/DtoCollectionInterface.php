<?php

declare(strict_types=1);

namespace App\Shared\Collection;

use App\Shared\Dtos\DtoInterface;

/**
 * @template TDtoCollectionElement
 *
 * @extends CollectionInterface<TDtoCollectionElement>
 */
interface DtoCollectionInterface extends CollectionInterface, DtoInterface
{
}
