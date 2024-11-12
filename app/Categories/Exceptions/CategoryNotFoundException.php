<?php

declare(strict_types=1);

namespace App\Categories\Exceptions;

use App\Shared\Exceptions\Http\Abstract\HttpNotFoundException;

final class CategoryNotFoundException extends HttpNotFoundException
{
    /** @param string[] $data */
    public function __construct(string $message = 'Category not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
