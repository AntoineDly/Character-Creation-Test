<?php

declare(strict_types=1);

namespace App\Shared\Controllers\ApiController;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Http\Enums\HttpStatusEnum;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Http\Exceptions\InvalidBodyParamsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class ApiController implements ApiControllerInterface
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    /**
     * @param  string[][]|string[]|int[]  $data
     */
    public function sendError(string $error, array $data = [], HttpStatusEnum $status = HttpStatusEnum::BAD_REQUEST): JsonResponse
    {
        if ($status->isInternalError()) {
            Log::error($error, $data);

            return $this->sendResponse(success: false, message: 'Internal Error.', data: [], status: HttpStatusEnum::INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse(success: false, message: $error, data: $data, status: $status);
    }

    public function sendException(HttpExceptionInterface $e): JsonResponse
    {
        $exceptionStatus = $e->getStatus();

        if ($exceptionStatus->isInternalError()) {
            return $this->sendError(
                error: $e->getMessage(),
                data: [
                    'className' => $e::class,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'traceAsString' => $e->getTraceAsString(),
                    'additionalData' => $e->getData(),
                ],
                status: $exceptionStatus,
            );
        }

        return $this->sendError(
            error: $e->getMessage(),
            data: $e->getData(),
            status: $exceptionStatus,
        );
    }

    /**
     * @param  string[][]|string[]|int[]|DtoInterface[]|DtoInterface  $data
     */
    public function sendResponse(bool $success, string $message, array|DtoInterface $data, HttpStatusEnum $status): JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];

        return $this->responseFactory->json(data: $response, status: $status->getCode());
    }

    /** @param DtoInterface[]|DtoInterface $content */
    public function sendSuccess(string $message, array|DtoInterface $content = [], HttpStatusEnum $status = HttpStatusEnum::OK): JsonResponse
    {
        return $this->sendResponse(success: true, message: $message, data: $content, status: $status);
    }

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse
    {
        $httpException = InvalidBodyParamsException::fromLaravelValidationException($message, $e);

        return $this->sendException($httpException);
    }

    public function sendExceptionNotCatch(Throwable $e): JsonResponse
    {
        return $this->sendError(
            error: 'Exception not catch.',
            data: [
                'className' => $e::class,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'traceAsString' => $e->getTraceAsString(),
            ],
            status: HttpStatusEnum::INTERNAL_SERVER_ERROR
        );
    }

    /** @param DtoInterface[]|DtoInterface $content */
    public function sendCreated(string $message, array|DtoInterface $content = []): JsonResponse
    {
        return $this->sendSuccess(message: $message, content: $content, status: HttpStatusEnum::CREATED);
    }
}
