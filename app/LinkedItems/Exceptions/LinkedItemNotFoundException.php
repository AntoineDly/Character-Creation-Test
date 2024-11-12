<?php

declare(strict_types=1);

namespace App\LinkedItems\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class LinkedItemNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Linked Item not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
