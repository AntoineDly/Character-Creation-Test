<?php

declare(strict_types=1);

namespace App\Users\Repositories;

use App\Shared\Repositories\AbstractRepository\RepositoryTrait;
use App\Users\Models\User;

final readonly class UserRepository implements UserRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
