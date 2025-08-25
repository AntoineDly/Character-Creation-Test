<?php

declare(strict_types=1);

namespace App\Items\Infrastructure\Repositories;

use App\Items\Domain\Models\Item;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<Item>
 */
interface ItemRepositoryInterface extends RepositoryInterface
{
}
