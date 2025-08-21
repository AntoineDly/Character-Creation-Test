<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Repositories;

use App\Shared\Repositories\RepositoryInterface;
use App\Users\Domain\Models\User;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
}
