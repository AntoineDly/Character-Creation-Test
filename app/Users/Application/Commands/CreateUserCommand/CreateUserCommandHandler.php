<?php

declare(strict_types=1);

namespace App\Users\Application\Commands\CreateUserCommand;

use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;
use App\Users\Infrastructure\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateUserCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateUserCommand::class]);
        }

        $password = Hash::make($command->password);
        $rememberToken = Str::random(10);

        $this->userRepository->create(['email' => $command->email, 'password' => $password, 'remember_token' => $rememberToken]);
    }
}
