<?php

declare(strict_types=1);

namespace App\Parameters\Models;

use App\Base\Traits\Uuid;
use App\Categories\Models\Category;
use App\Fields\Models\Field;
use App\Parameters\Enums\TypeEnum;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Parameter extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];

    protected $casts = [
        'type' => TypeEnum::class,
    ];

    /**
     * Get the user that created the parameter.
     *
     * @return BelongsTo<User, Parameter>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parameters of the category.
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'categories_parameters');
    }

    /**
     * Get the fields of the parameter.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
