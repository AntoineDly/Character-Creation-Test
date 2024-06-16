<?php

declare(strict_types=1);

namespace App\Base\Controllers\ApiController;

use Illuminate\Http\JsonResponse;

interface ApiControllerInterface
{
    /**
     * @param  array<mixed, mixed>  $content
     */
    public function sendSuccess(string $message, array $content = [], int $statusCode = 200): JsonResponse;

    /**
     * @param  array<mixed, mixed>  $errorContent
     */
    public function sendError(string $error, mixed $errorContent = [], int $statusCode = 404): JsonResponse;

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendResponse(bool $success, string $message, mixed $data, int $status): JsonResponse;
}
