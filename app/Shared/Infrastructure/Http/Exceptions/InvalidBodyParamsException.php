<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpUnprocessableEntityException;
use Illuminate\Validation\ValidationException;

final class InvalidBodyParamsException extends HttpUnprocessableEntityException
{
    public static function fromLaravelValidationException(string $message, ValidationException $e): static
    {
        return new InvalidBodyParamsException(message: $message, data: $e->errors());
    }
}
