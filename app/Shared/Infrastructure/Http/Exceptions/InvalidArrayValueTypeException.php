<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidArrayValueTypeException extends HttpInternalServerErrorException
{
}
