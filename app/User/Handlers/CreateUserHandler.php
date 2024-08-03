<?php

declare(strict_types=1);

namespace App\User\Handlers;

use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\User\Commands\CreateUserCommand;
use App\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final readonly class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateUserCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateGameCommand');
        }

        $password = Hash::make($command->password);
        $rememberToken = Str::random(10);

        $this->userRepository->create(['name' => $command->name, 'email' => $command->email, 'password' => $password, 'remember_token' => $rememberToken]);
    }
}
