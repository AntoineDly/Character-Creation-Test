<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions\Abstract;

use App\Shared\Http\Enums\HttpStatusEnum;

abstract class HttpUnprocessableEntityException extends AbstractHttpException
{
    public function __construct(string $message, array $data = [])
    {
        parent::__construct($message, HttpStatusEnum::UNPROCESSABLE_ENTITY, $data);
    }
}
