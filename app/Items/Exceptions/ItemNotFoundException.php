<?php

declare(strict_types=1);

namespace App\Items\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class ItemNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Item not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
