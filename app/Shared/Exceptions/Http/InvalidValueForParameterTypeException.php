<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class InvalidValueForParameterTypeException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Value should be castable to parameterType', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
