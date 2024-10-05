<?php

declare(strict_types=1);

namespace App\Users\Queries;

use App\Shared\Queries\QueryInterface;
use App\Users\Builders\UserDtoBuilder;
use App\Users\Dtos\UserDto;
use App\Users\Exceptions\CantCreateTokenException;
use App\Users\Exceptions\UserNotFoundException;
use App\Users\Exceptions\WrongPasswordException;
use App\Users\Models\User;
use App\Users\Repositories\UserRepositoryInterface;
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
            throw new UserNotFoundException(message: 'User not found', code: 404);
        }

        $isGoodPassword = Hash::check($this->password, $user->password);

        if (! $isGoodPassword) {
            throw new WrongPasswordException(message: 'The password is wrong', code: 400);
        }

        try {
            $token = $user->createToken('Laravel Personal Access Client')->accessToken;
        } catch (Exception $e) {
            throw new CantCreateTokenException(message: 'The token could not be created => '.$e->getMessage(), code: 500);
        }

        return $this->userDtoBuilder
            ->setId(id: $user->id)
            ->setName(name: $user->name)
            ->setEmail(email: $user->email)
            ->setToken(token: $token)
            ->build();
    }
}
