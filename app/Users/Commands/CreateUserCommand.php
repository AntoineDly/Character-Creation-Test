<?php

declare(strict_types=1);

namespace App\Users\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
