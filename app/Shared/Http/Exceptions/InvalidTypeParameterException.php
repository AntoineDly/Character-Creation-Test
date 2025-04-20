<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidTypeParameterException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Invalid parameter type', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
