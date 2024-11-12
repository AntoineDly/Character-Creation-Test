<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class StringIsEmptyException extends HttpInternalServerErrorException
{
    /** @param string[] $data */
    public function __construct(string $message = 'String is empty.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
