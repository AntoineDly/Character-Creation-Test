<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Exceptions\UserNotFoundException;
use Illuminate\Http\Request;

abstract readonly class RequestHelper
{
    public static function getUserId(Request $request): string
    {
        $user = $request->user();
        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        /** @var array{'id': string} $userData */
        $userData = $user->toArray();

        return $userData['id'];
    }
}
