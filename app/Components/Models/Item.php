<?php

declare(strict_types=1);

namespace App\Components\Models;

use App\Categories\Models\Category;
use App\Character\Models\Character;
use App\DefaultItemFields\Models\DefaultItemField;
use App\Fields\Models\Field;
use App\Game\Models\Game;
use App\Shared\Traits\Uuid;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Component extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user that created the component.
     *
     * @return BelongsTo<User, Component>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fields of the component.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Get the default fields of the component.
     *
     * @return HasMany<DefaultItemField>
     */
    public function defaultItemFields(): HasMany
    {
        return $this->hasMany(DefaultItemField::class);
    }

    /**
     * Get the characters of the component.
     *
     * @return BelongsToMany<Character>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)->withTimestamps();
    }

    /**
     * Get the games of the component.
     *
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withTimestamps();
    }

    /**
     * Get the categories of the component.
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
