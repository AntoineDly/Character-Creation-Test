<?php

declare(strict_types=1);

namespace App\Shared\Exceptions\Http;

use App\Shared\Enums\HttpStatusEnum;
use Throwable;

interface HttpExceptionInterface extends Throwable
{
    public function getStatus(): HttpStatusEnum;

    /** @return array<mixed, mixed> */
    public function getData(): array;
}
