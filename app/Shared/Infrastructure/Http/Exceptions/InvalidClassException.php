<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidClassException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Object isn\'t of the valid class.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
