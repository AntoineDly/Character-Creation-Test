<?php

declare(strict_types=1);

namespace App\ComponentFields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class ComponentFieldNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'ComponentField not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
