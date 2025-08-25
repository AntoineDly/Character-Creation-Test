<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidValueForParameterTypeException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Value should be castable to parameterType', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
