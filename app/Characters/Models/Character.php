<?php

declare(strict_types=1);

namespace App\Characters\Models;

use App\Games\Models\Game;
use App\LinkedItems\Models\LinkedItem;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\CharacterFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Character extends Model
{
    /** @use HasModelFactory<CharacterFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'game_id',
        'user_id',
    ];

    /**
     * Get the game of the character.
     *
     * @return BelongsTo<Game, Character>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the game of the character.
     *
     * @return BelongsTo<User, Character>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the linked items of the character.
     *
     * @return HasMany<LinkedItem>
     */
    public function linkedItems(): HasMany
    {
        return $this->hasMany(LinkedItem::class);
    }
}
