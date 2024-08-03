<?php

declare(strict_types=1);

namespace App\Shared\Controllers\ApiController;

use Exception;
use Illuminate\Http\JsonResponse;

interface ApiControllerInterface
{
    /**
     * @param  array<mixed, mixed>  $errorContent
     */
    public function sendError(string $error, mixed $errorContent = [], int $statusCode = 400): JsonResponse;

    public function sendException(Exception $exception): JsonResponse;

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendResponse(bool $success, string $message, mixed $data, int $status): JsonResponse;

    /**
     * @param  array<mixed, mixed>  $content
     */
    public function sendSuccess(string $message, array $content = [], int $statusCode = 200): JsonResponse;
}
