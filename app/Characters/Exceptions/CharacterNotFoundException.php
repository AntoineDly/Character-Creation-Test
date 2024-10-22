<?php

declare(strict_types=1);

namespace App\Characters\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class CharacterNotFoundException extends HttpNotFoundException
{
}
