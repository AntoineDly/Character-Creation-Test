<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class DefaultComponentFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Default Component Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
