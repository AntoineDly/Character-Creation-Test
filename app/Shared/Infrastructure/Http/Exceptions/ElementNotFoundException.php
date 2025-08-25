<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class ElementNotFoundException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Element not found.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
