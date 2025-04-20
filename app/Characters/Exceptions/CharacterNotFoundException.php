<?php

declare(strict_types=1);

namespace App\Characters\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class CharacterNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Character not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
