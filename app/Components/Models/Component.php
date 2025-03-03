<?php

declare(strict_types=1);

namespace App\Components\Models;

use App\ComponentFields\Models\ComponentField;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\ComponentFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Component extends Model
{
    /** @use HasModelFactory<ComponentFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
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
     * Get the Component fields of the component.
     *
     * @return HasMany<ComponentField>
     */
    public function componentFields(): HasMany
    {
        return $this->hasMany(ComponentField::class);
    }
}
