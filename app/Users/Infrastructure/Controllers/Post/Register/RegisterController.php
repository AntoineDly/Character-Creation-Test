<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controllers\Post\Register;

use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Users\Application\Commands\CreateUserCommand\CreateUserCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class RegisterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            /** @var array{'email': string, 'password': string} $validated */
            $validated = $request->validated();

            $command = new CreateUserCommand(
                email: $validated['email'],
                password: $validated['password'],
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'You haven\'t been registered.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'You have been successfully registered!');
    }
}
