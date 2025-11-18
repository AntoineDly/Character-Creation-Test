<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controllers\Post\Login;

use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Users\Application\Queries\GetUserQuery\GetUserQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class LoginController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            /** @var array{'email': string, 'password': string} $validated */
            $validated = $request->validated();

            $query = new GetUserQuery(
                email: $validated['email'],
                password: $validated['password'],
            );
            $result = $this->queryBus->dispatch($query);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'You haven\'t been logged in.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'You have been successfully logged in!', content: $result);
    }
}
