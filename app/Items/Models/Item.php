<?php

declare(strict_types=1);

namespace App\Items\Models;

use App\Base\Traits\Uuid;
use App\Categories\Models\Category;
use App\Character\Models\Character;
use App\Fields\Models\DefaultField;
use App\Fields\Models\Field;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the fields of the item.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Get the default fields of the item.
     *
     * @return HasMany<DefaultField>
     */
    public function defaultFields(): HasMany
    {
        return $this->hasMany(DefaultField::class);
    }

    /**
     * Get the characters of the item.
     *
     * @return BelongsToMany<Character>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class);
    }
}
