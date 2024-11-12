<?php

declare(strict_types=1);

namespace App\Parameters\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ParameterNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Parameter not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
