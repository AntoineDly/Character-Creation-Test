<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http\Abstract;

use App\Shared\Enums\HttpStatusEnum;

abstract class HttpNotFoundException extends AbstractHttpException
{
    /** @param string[] $data */
    public function __construct(string $message = '', array $data = [])
    {
        parent::__construct($message, HttpStatusEnum::NOT_FOUND, $data);
    }
}
