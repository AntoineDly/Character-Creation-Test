<?php

declare(strict_types=1);

namespace App\Users\Domain\Dtos\UserDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class UserDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $email,
        public string $token,
    ) {
    }
}
