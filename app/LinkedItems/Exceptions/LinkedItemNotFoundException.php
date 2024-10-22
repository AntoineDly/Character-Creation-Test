<?php

declare(strict_types=1);

namespace App\LinkedItems\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class LinkedItemNotFoundException extends HttpNotFoundException
{
}
