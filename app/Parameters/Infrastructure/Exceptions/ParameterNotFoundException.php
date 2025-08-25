<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpNotFoundException;

final class ParameterNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Parameter not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
