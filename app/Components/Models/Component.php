<?php

declare(strict_types=1);

namespace App\Components\Models;

use App\DefaultComponentFields\Models\DefaultComponentField;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Component extends Model
{
    use Uuid;

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
     * Get the default component fields of the component.
     *
     * @return HasMany<DefaultComponentField>
     */
    public function defaultComponentFields(): HasMany
    {
        return $this->hasMany(DefaultComponentField::class);
    }
}
