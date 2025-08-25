<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpNotFoundException;

final class GameNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Game not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
