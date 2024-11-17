<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class InvalidTypeParameterException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Invalid parameter type', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
