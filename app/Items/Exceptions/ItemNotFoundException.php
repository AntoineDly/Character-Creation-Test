<?php

declare(strict_types=1);

namespace App\Items\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ItemNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Item not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
