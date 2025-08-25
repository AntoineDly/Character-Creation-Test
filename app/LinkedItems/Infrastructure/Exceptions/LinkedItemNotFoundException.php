<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpNotFoundException;

final class LinkedItemNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'LinkedItem not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
