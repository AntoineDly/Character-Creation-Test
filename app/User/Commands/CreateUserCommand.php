<?php

declare(strict_types=1);

namespace App\User\Commands;

use App\Base\Commands\CommandInterface;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
