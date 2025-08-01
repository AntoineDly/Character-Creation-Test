<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class PlayableItemFieldNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Playable ItemField not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
