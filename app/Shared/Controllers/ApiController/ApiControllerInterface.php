<?php

declare(strict_types=1);

namespace App\Shared\Controllers\ApiController;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Enums\HttpStatusEnum;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

interface ApiControllerInterface
{
    /** @param string[][]|string[]|int[] $data */
    public function sendError(string $error, array $data = [], HttpStatusEnum $status = HttpStatusEnum::BAD_REQUEST): JsonResponse;

    public function sendException(HttpExceptionInterface $e): JsonResponse;

    /**
     * @param  string[][]|string[]|int[]|DtoInterface[]|DtoInterface  $data
     */
    public function sendResponse(bool $success, string $message, array|DtoInterface $data, HttpStatusEnum $status): JsonResponse;

    /** @param DtoInterface[]|DtoInterface $content */
    public function sendSuccess(string $message, array|DtoInterface $content = [], HttpStatusEnum $status = HttpStatusEnum::OK): JsonResponse;

    /** @param DtoInterface[]|DtoInterface $content */
    public function sendCreated(string $message, array|DtoInterface $content = []): JsonResponse;

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse;

    public function sendExceptionNotCatch(Throwable $e): JsonResponse;
}
