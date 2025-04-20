<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidValueForParameterTypeException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Value should be castable to parameterType', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
