<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class StringIsEmptyException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'String is empty.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
