<?php

declare(strict_types=1);

namespace App\Games\Models;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\Components\Models\Component;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * Get the components of the game.
     *
     * @return BelongsToMany<Component>
     */
    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class)->withTimestamps();
    }
}