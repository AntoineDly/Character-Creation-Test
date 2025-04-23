<?php

declare(strict_types=1);

namespace App\Shared\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * @template T
 *
 * @extends ArrayAccess<mixed, T>
 * @extends IteratorAggregate<T>
 */
interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
}
