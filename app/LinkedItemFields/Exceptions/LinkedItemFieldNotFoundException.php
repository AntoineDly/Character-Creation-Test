<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class LinkedItemFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Linked Item Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
