<?php

declare(strict_types=1);

namespace App\Base\Controllers\ApiController;

use App\Helpers\ArrayHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;

final readonly class ApiController implements ApiControllerInterface
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    /**
     * @param  array<mixed, mixed>  $errorContent
     */
    public function sendError(string $error, mixed $errorContent = [], int $statusCode = 404): JsonResponse
    {
        return $this->sendResponse(success: false, message: $error, data: $errorContent, status: $statusCode);
    }

    public function sendException(Exception $exception): JsonResponse
    {
        return $this->sendError(error: $exception->getMessage(), statusCode: $exception->getCode());
    }

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendResponse(bool $success, string $message, mixed $data, int $status): JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (! ArrayHelper::isEmpty($data)) {
            $response['data'] = $data;
        }

        return $this->responseFactory->json(data: $response, status: $status);
    }

    /**
     * @param  array<mixed, mixed>  $content
     */
    public function sendSuccess(string $message, array $content = [], int $statusCode = 200): JsonResponse
    {
        return $this->sendResponse(success: true, message: $message, data: $content, status: $statusCode);
    }
}
