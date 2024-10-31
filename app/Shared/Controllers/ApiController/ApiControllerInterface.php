<?php

declare(strict_types=1);

namespace App\Shared\Controllers\ApiController;

use App\Shared\Enums\HttpStatusEnum;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

interface ApiControllerInterface
{
    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendError(string $error, mixed $data = [], HttpStatusEnum $status = HttpStatusEnum::BAD_REQUEST): JsonResponse;

    public function sendException(HttpExceptionInterface $exception): JsonResponse;

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendResponse(bool $success, string $message, mixed $data, HttpStatusEnum $status): JsonResponse;

    /** @param  array<mixed, mixed>  $content */
    public function sendSuccess(string $message, array $content = [], HttpStatusEnum $status = HttpStatusEnum::OK): JsonResponse;

    /** @param  array<mixed, mixed>  $content */
    public function sendCreated(string $message, array $content = []): JsonResponse;

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse;

    public function sendExceptionNotCatch(Exception $e): JsonResponse;
}
