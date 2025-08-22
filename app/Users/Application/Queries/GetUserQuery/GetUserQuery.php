<?php

declare(strict_types=1);

namespace App\Users\Application\Queries\GetUserQuery;

use App\Shared\Queries\QueryInterface;
use App\Users\Domain\Dtos\UserDto\UserDto;
use App\Users\Domain\Dtos\UserDto\UserDtoBuilder;
use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Exceptions\CantCreateTokenException;
use App\Users\Infrastructure\Exceptions\UserNotFoundException;
use App\Users\Infrastructure\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;

final class GetUserQuery implements QueryInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserDtoBuilder $userDtoBuilder,
        private string $email,
        private string $password,
    ) {
    }

    public function get(): UserDto
    {
        $user = $this->userRepository->findByAttribute(column: 'email', value: $this->email);
        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        $isGoodPassword = Hash::check($this->password, $user->password);

        if (! $isGoodPassword) {
            throw new UserNotFoundException();
        }

        try {
            $token = $user->createToken('Laravel Personal Access Client')->accessToken;
        } catch (Exception $e) {
            throw new CantCreateTokenException(message: 'The token could not be created => '.$e->getMessage());
        }

        return $this->userDtoBuilder
            ->setId(id: $user->id)
            ->setEmail(email: $user->email)
            ->setToken(token: $token)
            ->build();
    }
}
