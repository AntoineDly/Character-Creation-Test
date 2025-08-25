<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controllers\ApiController;

use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Infrastructure\Http\Enums\HttpStatusEnum;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

interface ApiControllerInterface
{
    /** @param string[][]|string[]|int[] $data */
    public function sendError(string $error, array $data = [], HttpStatusEnum $status = HttpStatusEnum::BAD_REQUEST): JsonResponse;

    public function sendException(HttpExceptionInterface $e): JsonResponse;

    /**
     * @param  string[][]|string[]|int[]|DtoInterface  $data
     */
    public function sendResponse(bool $success, string $message, array|DtoInterface $data, HttpStatusEnum $status): JsonResponse;

    public function sendSuccess(string $message, ?DtoInterface $content = null, HttpStatusEnum $status = HttpStatusEnum::OK): JsonResponse;

    public function sendCreated(string $message): JsonResponse;

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse;

    public function sendUncaughtThrowable(Throwable $e): JsonResponse;
}
