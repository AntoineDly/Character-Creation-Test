<?php

declare(strict_types=1);

namespace App\Shared\Application\Queries;

use App\Shared\Infrastructure\Http\Exceptions\Abstract\HttpInternalServerErrorException;

final class IncorrectQueryException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Query must be a correct Instance for the handler.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
