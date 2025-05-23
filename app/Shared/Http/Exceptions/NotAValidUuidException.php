<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class NotAValidUuidException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'id field is not a valid uuid.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
