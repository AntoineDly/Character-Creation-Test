<?php

declare(strict_types=1);

namespace App\Items\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class ItemNotFoundException extends HttpNotFoundException
{
}
