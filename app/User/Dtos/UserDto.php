<?php

declare(strict_types=1);

namespace App\User\Dtos;

use App\Base\Dtos\DtoInterface;

final readonly class UserDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $token,
    ) {
    }
}
