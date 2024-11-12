<?php

declare(strict_types=1);

namespace App\Users\Controllers\Api;

use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Users\Builders\UserDtoBuilder;
use App\Users\Commands\CreateUserCommand;
use App\Users\Exceptions\TokenNotFoundException;
use App\Users\Exceptions\UserNotFoundException;
use App\Users\Models\User;
use App\Users\Queries\GetUserQuery;
use App\Users\Repositories\UserRepositoryInterface;
use App\Users\Requests\LoginRequest;
use App\Users\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Token;

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

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'You haven\'t been registered.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
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
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'You have been successfully logged in!', content: [$result]);
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
