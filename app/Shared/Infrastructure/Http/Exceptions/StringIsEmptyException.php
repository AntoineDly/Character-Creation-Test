<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class StringIsEmptyException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'String is empty.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
