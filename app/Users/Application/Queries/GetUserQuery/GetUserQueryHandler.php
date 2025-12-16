<?php

declare(strict_types=1);

namespace App\Users\Application\Queries\GetUserQuery;

use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Users\Domain\Dtos\UserDto\UserDto;
use App\Users\Domain\Dtos\UserDto\UserDtoBuilder;
use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Exceptions\CantCreateTokenException;
use App\Users\Infrastructure\Exceptions\UserNotFoundException;
use App\Users\Infrastructure\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Throwable;

final readonly class GetUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function handle(QueryInterface $query): UserDto
    {
        if (! $query instanceof GetUserQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetUserQuery::class]);
        }
        $user = $this->userRepository->findByAttribute(column: 'email', value: $query->email);
        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        $isGoodPassword = Hash::check($query->password, $user->password);

        if (! $isGoodPassword) {
            throw new UserNotFoundException();
        }

        try {
            $token = $user->createToken('CharacterCreationAPI Personal Access Client')->accessToken;
        } catch (Throwable $e) {
            throw new CantCreateTokenException(message: 'The token could not be created => '.$e->getMessage());
        }

        return UserDtoBuilder::create()
            ->setId(id: $user->id)
            ->setEmail(email: $user->email)
            ->setToken(token: $token)
            ->build();
    }
}
