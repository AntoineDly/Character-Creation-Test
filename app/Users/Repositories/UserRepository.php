<?php

declare(strict_types=1);

namespace App\Users\Repositories;

use App\Shared\Repositories\RepositoryTrait;
use App\Users\Models\User;

final readonly class UserRepository implements UserRepositoryInterface
{
    /** @use RepositoryTrait<User> */
    use RepositoryTrait;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
