<?php

declare(strict_types=1);

namespace App\Parameters\Models;

use App\DefaultItemFields\Models\DefaultItemField;
use App\Fields\Models\Field;
use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\ParameterFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Parameter extends Model
{
    /** @use HasModelFactory<ParameterFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];

    protected $casts = [
        'type' => TypeParameterEnum::class,
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
     * @return HasMany<DefaultItemField>
     */
    public function defaultItemFields(): HasMany
    {
        return $this->hasMany(DefaultItemField::class);
    }
}
