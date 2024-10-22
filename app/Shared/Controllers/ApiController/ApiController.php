<?php

declare(strict_types=1);

namespace App\Shared\Controllers\ApiController;

use App\Helpers\ArrayHelper;
use App\Shared\Enums\HttpStatusEnum;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Exceptions\Http\InvalidBodyParamsException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

final readonly class ApiController implements ApiControllerInterface
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendError(string $error, mixed $data = [], HttpStatusEnum $status = HttpStatusEnum::BAD_REQUEST): JsonResponse
    {
        if ($status->isInternalError()) {
            Log::error($error, $data);

            return $this->sendResponse(success: false, message: 'Internal Error.', data: [], status: HttpStatusEnum::INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(success: false, message: $error, data: $data, status: $status);
    }

    public function sendException(HttpExceptionInterface $exception): JsonResponse
    {
        $exceptionStatus = $exception->getStatus();

        return $this->sendError(
            error: $exception->getMessage(),
            data: $exception->getData(),
            status: $exceptionStatus,
        );
    }

    /**
     * @param  array<mixed, mixed>  $data
     */
    public function sendResponse(bool $success, string $message, mixed $data, HttpStatusEnum $status): JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (! ArrayHelper::isEmpty($data)) {
            $response['data'] = $data;
        }

        return $this->responseFactory->json(data: $response, status: $status->getCode());
    }

    /**
     * @param  array<mixed, mixed>  $content
     */
    public function sendSuccess(string $message, array $content = [], HttpStatusEnum $status = HttpStatusEnum::OK): JsonResponse
    {
        return $this->sendResponse(success: true, message: $message, data: $content, status: $status);
    }

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse
    {
        $httpException = InvalidBodyParamsException::fromLaravelValidationException($message, $e);

        return $this->sendException($httpException);
    }

    public function sendExceptionNotCatch(Exception $e): JsonResponse
    {
        return $this->sendError(
            error: 'Exception : '.$e::class.'not catch.',
            data: [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ],
            status: HttpStatusEnum::INTERNAL_SERVER_ERROR
        );
    }
}
