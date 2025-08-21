<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Repositories;

use App\LinkedItems\Domain\Models\LinkedItem;
use App\Shared\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<LinkedItem>
 */
interface LinkedItemRepositoryInterface extends RepositoryInterface
{
}
