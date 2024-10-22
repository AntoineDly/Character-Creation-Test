<?php

declare(strict_types=1);

namespace App\Components\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ComponentNotFoundException extends HttpNotFoundException
{
}
