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

            return $this->sendResponse(success: false, message: 'Internal Error.', data: [], status: HttpStatusEnum::INTERNAL_SERVER_ERROR, withData: false);
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
     * @param  null|string[][]|string[]|int[]|DtoInterface  $data
     */
    public function sendResponse(bool $success, string $message, null|array|DtoInterface $data = null, HttpStatusEnum $status, bool $withData = true): JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if ($withData) {
            $response['data'] = $data;
        }

        return $this->responseFactory->json(data: $response, status: $status->getCode());
    }

    public function sendSuccess(string $message, ?DtoInterface $content = null, HttpStatusEnum $status = HttpStatusEnum::OK, bool $withData = true): JsonResponse
    {
        return $this->sendResponse(success: true, message: $message, data: $content, status: $status, withData: $withData);
    }

    public function sendExceptionFromLaravelValidationException(string $message, ValidationException $e): JsonResponse
    {
        $httpException = InvalidBodyParamsException::fromLaravelValidationException($message, $e);

        return $this->sendException($httpException);
    }

    public function sendUncaughtThrowable(Throwable $e): JsonResponse
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

    public function sendCreated(string $message): JsonResponse
    {
        return $this->sendSuccess(message: $message, status: HttpStatusEnum::CREATED, withData: false);
    }
}
