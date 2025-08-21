<?php

declare(strict_types=1);

namespace App\Components\Infrastructure\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class ComponentNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Component not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
