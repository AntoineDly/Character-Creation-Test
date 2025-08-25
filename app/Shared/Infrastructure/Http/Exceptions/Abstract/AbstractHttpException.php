<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions\Abstract;

use App\Shared\Infrastructure\Http\Enums\HttpStatusEnum;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Exception;

abstract class AbstractHttpException extends Exception implements HttpExceptionInterface
{
    /** @param string[] $data */
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

    /** @return string[] */
    public function getData(): array
    {
        return $this->data;
    }
}
