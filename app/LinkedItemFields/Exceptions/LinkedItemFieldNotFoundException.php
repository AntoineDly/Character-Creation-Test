<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class LinkedItemFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'LinkedItemField not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
