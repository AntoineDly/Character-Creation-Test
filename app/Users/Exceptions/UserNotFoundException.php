<?php

declare(strict_types=1);

namespace App\Users\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class UserNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'User not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
