<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http\Abstract;

use App\Shared\Enums\HttpStatusEnum;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;

abstract class AbstractHttpException extends Exception implements HttpExceptionInterface
{
    /** @param array<mixed, mixed> $data */
    public function __construct(
        string $message,
        private readonly HttpStatusEnum $status,
        private readonly array $data
    ) {
        parent::__construct($message, $status->getCode());
    }

    public function getStatus(): HttpStatusEnum
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
