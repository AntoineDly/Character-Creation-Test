<?php

declare(strict_types=1);

namespace App\Parameters\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ParameterNotFoundException extends HttpNotFoundException
{
}
