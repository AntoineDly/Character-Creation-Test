<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controllers\Post\Logout;

use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Exceptions\TokenNotFoundException;
use App\Users\Infrastructure\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

final readonly class LogoutController
{
    public function __construct(
        private ApiControllerInterface $apiController,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
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
