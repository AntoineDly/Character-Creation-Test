<?php

declare(strict_types=1);

namespace App\Users\Repositories;

use App\Shared\Repositories\AbstractRepository\AbstractRepository;
use App\Users\Models\User;

final readonly class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
