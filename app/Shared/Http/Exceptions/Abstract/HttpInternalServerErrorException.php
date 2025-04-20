<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions\Abstract;

use App\Shared\Http\Enums\HttpStatusEnum;

abstract class HttpInternalServerErrorException extends AbstractHttpException
{
    /** @param string[] $data */
    public function __construct(string $message = '', array $data = [])
    {
        parent::__construct($message, HttpStatusEnum::NOT_FOUND, $data);
    }
}
