<?php

declare(strict_types=1);

namespace App\PlayableItems\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class PlayableItemNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'PlayableItem not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
