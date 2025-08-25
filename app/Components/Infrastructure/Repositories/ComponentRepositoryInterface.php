<?php

declare(strict_types=1);

namespace App\Components\Infrastructure\Repositories;

use App\Components\Domain\Models\Component;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<Component>
 */
interface ComponentRepositoryInterface extends RepositoryInterface
{
}
