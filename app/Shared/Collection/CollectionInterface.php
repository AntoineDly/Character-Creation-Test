<?php

declare(strict_types=1);

namespace App\Shared\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * @template TCollectionElement
 *
 * @extends ArrayAccess<mixed, TCollectionElement>
 * @extends IteratorAggregate<TCollectionElement>
 */
interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
}
