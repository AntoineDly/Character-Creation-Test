<?php

declare(strict_types=1);

namespace App\Components\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ComponentNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Component not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
