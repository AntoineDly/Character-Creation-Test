<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class IsNotObjectException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Handler was expected to be an object', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
