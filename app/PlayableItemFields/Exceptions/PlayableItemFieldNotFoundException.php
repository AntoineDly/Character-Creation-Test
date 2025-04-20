<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class PlayableItemFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Playable Item Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
