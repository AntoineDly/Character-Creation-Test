<?php

declare(strict_types=1);

namespace App\Games\Models;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\PlayableItems\Models\PlayableItem;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Game extends Model
{
    /** @use HasModelFactory<GameFactory> */
    use HasModelFactory, Uuid;

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

    /**
     * Get the categories of the game.
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * Get the playableItems of the game.
     *
     * @return HasMany<PlayableItem>
     */
    public function playableItems(): HasMany
    {
        return $this->hasMany(PlayableItem::class);
    }
}
