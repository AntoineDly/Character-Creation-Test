<?php

declare(strict_types=1);

namespace App\Fields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class FieldInterfaceNotFoundException extends HttpNotFoundException
{
}
