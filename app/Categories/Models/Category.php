<?php

declare(strict_types=1);

namespace App\Categories\Models;

use App\Games\Models\Game;
use App\Items\Models\Item;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Category extends Model
{
    /** @use HasModelFactory<CategoryFactory> */
    use HasModelFactory, Uuid;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user that created the category.
     *
     * @return BelongsTo<User, Category>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the games with this category.
     *
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withTimestamps();
    }

    /**
     * Get the items of the category.
     *
     * @return HasMany<Item>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
