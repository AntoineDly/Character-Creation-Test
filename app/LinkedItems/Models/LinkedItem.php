<?php

declare(strict_types=1);

namespace App\LinkedItems\Models;

use App\Fields\Models\Field;
use App\Items\Models\Item;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\LinkedItemFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class LinkedItem extends Model
{
    /** @use HasModelFactory<LinkedItemFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'item_id',
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
     * Get the item of the linked item.
     *
     * @return BelongsTo<Item, LinkedItem>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the fields of the linked item.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
