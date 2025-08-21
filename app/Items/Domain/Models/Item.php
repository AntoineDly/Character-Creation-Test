<?php

declare(strict_types=1);

namespace App\Items\Domain\Models;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\ItemFields\Domain\Models\ItemField;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Domain\Models\User;
use Database\Factories\ItemFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Item extends Model
{
    /** @use HasModelFactory<ItemFactory> */
    use HasModelFactory, Uuid;

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
     * Get the component of the item.
     *
     * @return BelongsTo<Component, Item>
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the category of the item.
     *
     * @return BelongsTo<Category, Item>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the default fields of the item.
     *
     * @return HasMany<ItemField>
     */
    public function itemFields(): HasMany
    {
        return $this->hasMany(ItemField::class);
    }
}
