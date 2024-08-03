<?php

declare(strict_types=1);

namespace App\Parameters\Models;

use App\DefaultFields\Models\DefaultField;
use App\Fields\Models\Field;
use App\Parameters\Enums\TypeEnum;
use App\Shared\Traits\Uuid;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * Get the fields of the parameter.
     *
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Get the default fields of the parameter.
     *
     * @return HasMany<DefaultField>
     */
    public function defaultFields(): HasMany
    {
        return $this->hasMany(DefaultField::class);
    }
}
