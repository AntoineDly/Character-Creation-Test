<?php

declare(strict_types=1);

namespace App\Games\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class GameNotFoundException extends HttpNotFoundException
{
}
