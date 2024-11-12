<?php

declare(strict_types=1);

namespace App\Fields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class FieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
