<?php

declare(strict_types=1);

namespace App\Users\Exceptions;

use App\Shared\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class CantCreateTokenException extends HttpInternalServerErrorException
{
}
