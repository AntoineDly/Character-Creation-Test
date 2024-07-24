<?php

declare(strict_types=1);

namespace App\User\Queries;

use App\Base\Queries\QueryInterface;
use App\User\Builders\UserDtoBuilder;
use App\User\Dtos\UserDto;
use App\User\Exceptions\UserNotFoundException;
use App\User\Exceptions\WrongPasswordException;
use App\User\Models\User;
use App\User\Repositories\UserRepositoryInterface;
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

        //"personal access" and "password grant"
        try {
            $token = $user->createToken('Laravel Personal Access Client')->accessToken;
        } catch (Exception $e) {
            dd($e);
        }

        /** @var array{'id': string, 'name': string, 'email': string} $userData */
        $userData = $user->toArray();

        return $this->userDtoBuilder
            ->setId(id: $userData['id'])
            ->setName(name: $userData['name'])
            ->setEmail(email: $userData['email'])
            ->setToken(token: $token)
            ->build();
    }
}
