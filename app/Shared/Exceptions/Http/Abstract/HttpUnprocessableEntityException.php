<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http\Abstract;

use App\Shared\Enums\HttpStatusEnum;

abstract class HttpUnprocessableEntityException extends AbstractHttpException
{
    /** @param string[] $data */
    public function __construct(string $message, array $data = [])
    {
        parent::__construct($message, HttpStatusEnum::UNPROCESSABLE_ENTITY, $data);
    }
}
