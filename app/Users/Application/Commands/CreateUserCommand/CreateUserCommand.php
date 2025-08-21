<?php

declare(strict_types=1);

namespace App\Users\Application\Commands\CreateUserCommand;

use App\Shared\Commands\CommandInterface;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
