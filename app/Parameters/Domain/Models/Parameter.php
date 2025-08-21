<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Models;

use App\ItemFields\Domain\Models\ItemField;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Domain\Models\User;
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
     * @return HasMany<LinkedItemField>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(LinkedItemField::class);
    }

    /**
     * Get the default fields of the parameter.
     *
     * @return HasMany<ItemField>
     */
    public function itemFields(): HasMany
    {
        return $this->hasMany(ItemField::class);
    }
}
