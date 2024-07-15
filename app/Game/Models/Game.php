<?php

declare(strict_types=1);

namespace App\Game\Models;

use App\Base\Traits\Uuid;
use App\Character\Models\Character;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Game extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the characters of the game.
     *
     * @return HasMany<Character>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
