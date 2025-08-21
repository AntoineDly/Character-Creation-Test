<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Repositories;

use App\Shared\Repositories\RepositoryTrait;
use App\Users\Domain\Models\User;

final readonly class UserRepository implements UserRepositoryInterface
{
    /** @use RepositoryTrait<User> */
    use RepositoryTrait;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
