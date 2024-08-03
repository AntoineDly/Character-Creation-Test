<?php

declare(strict_types=1);

namespace App\User\Repositories;

use App\Shared\Repositories\AbstractRepository\AbstractRepository;
use App\User\Models\User;

final readonly class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
