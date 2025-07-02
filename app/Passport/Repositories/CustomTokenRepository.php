<?php

declare(strict_types=1);

namespace App\Passport\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\TokenRepository;

final class CustomTokenRepository extends TokenRepository
{
    public function isAccessTokenRevoked($id)
    {
        try {
            return parent::isAccessTokenRevoked($id);
        } catch (QueryException $e) {
            Log::error('Error during token revoked check: '.$e->getMessage());

            return true;
        }
    }
}
