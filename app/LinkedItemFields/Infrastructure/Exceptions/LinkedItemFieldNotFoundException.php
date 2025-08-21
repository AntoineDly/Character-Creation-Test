<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class LinkedItemFieldNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'LinkedItemField not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
