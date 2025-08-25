<?php

declare(strict_types=1);

namespace App\Characters\Domain\Models;

use App\Games\Domain\Models\Game;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\Shared\Domain\Traits\HasModelFactory;
use App\Shared\Domain\Traits\Uuid;
use App\Users\Domain\Models\User;
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
