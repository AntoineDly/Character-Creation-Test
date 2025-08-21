<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class TokenNotFoundException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Token not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
