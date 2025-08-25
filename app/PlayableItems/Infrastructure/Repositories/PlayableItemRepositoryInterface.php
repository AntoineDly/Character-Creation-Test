<?php

declare(strict_types=1);

namespace App\PlayableItems\Infrastructure\Repositories;

use App\PlayableItems\Domain\Models\PlayableItem;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<PlayableItem>
 */
interface PlayableItemRepositoryInterface extends RepositoryInterface
{
}
