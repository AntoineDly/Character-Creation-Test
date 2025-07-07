<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class ObjectNotFoundException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Object not found.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
