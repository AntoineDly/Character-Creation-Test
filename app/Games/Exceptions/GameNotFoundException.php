<?php

declare(strict_types=1);

namespace App\Games\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class GameNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Game not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
