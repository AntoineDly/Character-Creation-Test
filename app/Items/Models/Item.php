<?php

declare(strict_types=1);

namespace App\Items\Models;

use App\DefaultItemFields\Models\DefaultItemField;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Item extends Model
{
    use Uuid;

    protected $fillable = [
        'component_id',
        'category_id',
        'user_id',
    ];

    /**
     * Get the user that created the item.
     *
     * @return BelongsTo<User, Item>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the default fields of the item.
     *
     * @return HasMany<DefaultItemField>
     */
    public function defaultItemFields(): HasMany
    {
        return $this->hasMany(DefaultItemField::class);
    }
}
