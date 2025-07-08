<?php

declare(strict_types=1);

namespace App\Shared\Fields\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpNotFoundException;

final class FieldInterfaceNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Object implementing FieldInterface not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
