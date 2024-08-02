<?php

declare(strict_types=1);

namespace App\Items\Models;

use App\Base\Traits\Uuid;
use App\Categories\Models\Category;
use App\Character\Models\Character;
use App\DefaultFields\Models\DefaultField;
use App\Fields\Models\Field;
use App\Game\Models\Game;
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
        return $this->belongsToMany(Character::class)->withTimestamps();
    }

    /**
     * Get the games of the item.
     *
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withTimestamps();
    }

    /**
     * Get the categories of the item.
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
