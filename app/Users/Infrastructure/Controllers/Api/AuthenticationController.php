<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controllers\Api;

use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Users\Application\Commands\CreateUserCommand\CreateUserCommand;
use App\Users\Application\Queries\GetUserQuery\GetUserQuery;
use App\Users\Domain\Dtos\UserDto\UserDtoBuilder;
use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Exceptions\TokenNotFoundException;
use App\Users\Infrastructure\Exceptions\UserNotFoundException;
use App\Users\Infrastructure\Repositories\UserRepositoryInterface;
use App\Users\Infrastructure\Requests\LoginRequest;
use App\Users\Infrastructure\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Token;
use Throwable;

final readonly class AuthenticationController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private UserRepositoryInterface $userRepository,
        private UserDtoBuilder $userDtoBuilder,
        private CommandBus $commandBus,
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
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

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            /** @var array{'email': string, 'password': string} $validated */
            $validated = $request->validated();

            $query = new GetUserQuery(
                userRepository: $this->userRepository,
                userDtoBuilder: $this->userDtoBuilder,
                email: $validated['email'],
                password: $validated['password'],
            );
            $result = $query->get();
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

    public function logout(Request $request): JsonResponse
    {
        /** @var ?User $user */
        $user = $request->user();
        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }
        $token = $user->token();
        if (! $token instanceof Token) {
            throw new TokenNotFoundException();
        }
        $token->revoke();

        return $this->apiController->sendSuccess(message: 'You have been successfully logged out!');
    }
}
