<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class InvalidArrayValueTypeException extends HttpInternalServerErrorException
{
}
