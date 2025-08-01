<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Users\Exceptions\UserNotFoundException;
use App\Users\Models\User;
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
