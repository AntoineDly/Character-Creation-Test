<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Models;

use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\PlayableItems\Domain\Models\PlayableItem;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Domain\Models\User;
use Database\Factories\LinkedItemFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class LinkedItem extends Model
{
    /** @use HasModelFactory<LinkedItemFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'playable_item_id',
        'character_id',
        'user_id',
    ];

    /**
     * Get the user that created the linked item.
     *
     * @return BelongsTo<User, LinkedItem>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the playable item of the linked item.
     *
     * @return BelongsTo<PlayableItem, LinkedItem>
     */
    public function playableItem(): BelongsTo
    {
        return $this->belongsTo(PlayableItem::class);
    }

    /**
     * Get the fields of the linked item.
     *
     * @return HasMany<LinkedItemField>
     */
    public function linkedItemFields(): HasMany
    {
        return $this->hasMany(LinkedItemField::class);
    }
}
