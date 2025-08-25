<?php

declare(strict_types=1);

namespace App\Users\Application\Queries\GetUserQuery;

use App\Shared\Application\Queries\QueryInterface;

final class GetUserQuery implements QueryInterface
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
