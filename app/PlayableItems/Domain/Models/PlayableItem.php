<?php

declare(strict_types=1);

namespace App\PlayableItems\Domain\Models;

use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Domain\Models\User;
use Database\Factories\PlayableItemFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PlayableItem extends Model
{
    /** @use HasModelFactory<PlayableItemFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'item_id',
        'game_id',
        'user_id',
    ];

    /**
     * Get the user that created the playable item.
     *
     * @return BelongsTo<User, PlayableItem>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the item of the playable item.
     *
     * @return BelongsTo<Item, PlayableItem>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the game of the playable item.
     *
     * @return BelongsTo<Game, PlayableItem>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the PlayableItem fields of the playableItem.
     *
     * @return HasMany<PlayableItemField>
     */
    public function playableItemFields(): HasMany
    {
        return $this->hasMany(PlayableItemField::class);
    }
}
