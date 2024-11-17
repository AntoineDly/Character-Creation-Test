<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Exceptions\Http\Abstract\HttpInternalServerErrorException;

final class IncorrectCommandException extends HttpInternalServerErrorException
{
    public function __construct(string $message = 'Command must be a correct Instance for the handler.', array $data = [])
    {
        parent::__construct($message, $data);
    }
}
