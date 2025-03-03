<?php

declare(strict_types=1);

namespace App\Shared\Fields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class FieldInterfaceNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Object implementing FieldInterface not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
