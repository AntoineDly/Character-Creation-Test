<?php

declare(strict_types=1);

namespace App\LinkedItems\Models;

use App\Fields\Models\Field;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class LinkedItem extends Model
{
    use Uuid;

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
     * Get the fields of the linked item.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
