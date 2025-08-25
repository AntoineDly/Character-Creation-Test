<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Exceptions;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpNotFoundException;

final class CategoryNotFoundException extends HttpNotFoundException
{
    public function __construct(string $message = 'Category not found.', array $data = [])
    {
        parent::__construct(message: $message, data: $data);
    }
}
