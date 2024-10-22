<?php

declare(strict_types=1);

namespace App\Categories\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class CategoryNotFoundException extends HttpNotFoundException
{
}
