<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class InvalidEnumException extends HttpInternalServerErrorException
{
}
