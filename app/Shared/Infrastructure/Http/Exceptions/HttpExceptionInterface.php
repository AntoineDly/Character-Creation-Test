<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exceptions;

use App\Shared\Infrastructure\Http\Enums\HttpStatusEnum;
use Throwable;

interface HttpExceptionInterface extends Throwable
{
    public function getStatus(): HttpStatusEnum;

    /** @return string[] */
    public function getData(): array;
}
