<?php

declare(strict_types=1);

namespace App\ItemFields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class ItemFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Item Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
