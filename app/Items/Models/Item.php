<?php

declare(strict_types=1);

namespace App\Items\Models;

use App\Base\Traits\Uuid;
use App\Categories\Models\Category;
use App\Character\Models\Character;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Item extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'categorie_id',
        'user_id',
    ];

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
     * Get the user that created the item.
     *
     * @return BelongsTo<User, Item>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parameters of the category.
     *
     * @return BelongsToMany<Character>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'items_characters');
    }
}
