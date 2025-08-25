<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class CantCreateTokenException extends HttpInternalServerErrorException
{
}
