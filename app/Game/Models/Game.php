<?php

declare(strict_types=1);

namespace App\Game\Models;

use App\Base\Traits\Uuid;
use App\Character\Models\Character;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Game extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'visible_for_all',
        'user_id',
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

    /**
     * Get the game of the character.
     *
     * @return BelongsTo<User, Game>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}