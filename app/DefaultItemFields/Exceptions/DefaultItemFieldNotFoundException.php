<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class DefaultItemFieldNotFoundException extends HttpNotFoundException
{
}
