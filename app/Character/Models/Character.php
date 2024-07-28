<?php

declare(strict_types=1);

namespace App\Character\Models;

use App\Base\Traits\Uuid;
use App\Fields\Models\Field;
use App\Game\Models\Game;
use App\Items\Models\Item;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Character extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
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
     * Get the fields of the character.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Get the items of the character.
     *
     * @return BelongsToMany<Item>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withTimestamps();
    }
}
