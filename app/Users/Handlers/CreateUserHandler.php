<?php

declare(strict_types=1);

namespace App\Users\Handlers;

use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Users\Commands\CreateUserCommand;
use App\Users\Repositories\UserRepositoryInterface;
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

        $this->userRepository->create(['email' => $command->email, 'password' => $password, 'remember_token' => $rememberToken]);
    }
}
