<?php

declare(strict_types=1);

namespace App\PlayableItems\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class PlayableItemNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'PlayableItem not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
