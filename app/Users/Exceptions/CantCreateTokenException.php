<?php

declare(strict_types=1);

namespace App\Users\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class CantCreateTokenException extends HttpInternalServerErrorException
{
}
