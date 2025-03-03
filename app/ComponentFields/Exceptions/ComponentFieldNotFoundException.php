<?php

declare(strict_types=1);

namespace App\ComponentFields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ComponentFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Component Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
