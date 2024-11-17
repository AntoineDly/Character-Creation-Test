<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class IsNotObjectException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Handler was expected to be an object', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
