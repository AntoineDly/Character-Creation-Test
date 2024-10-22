<?php

declare(strict_types=1);

namespace App\Users\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class UserNotFoundException extends HttpNotFoundException
{
}
