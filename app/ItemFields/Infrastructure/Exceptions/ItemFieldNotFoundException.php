<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class ItemFieldNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'ItemField not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
