<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class DefaultItemFieldNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Default Item Field not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
