<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Character\Models\Character;
use App\Components\Models\Component;
use App\Parameters\Models\Parameter;
use App\Shared\Traits\Uuid;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Field extends Model
{
    use Uuid;

    protected $fillable = [
        'value',
        'component_id',
        'character_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the component.
     *
     * @return BelongsTo<User, Field>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the component of the field.
     *
     * @return BelongsTo<Component, Field>
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the character of the field.
     *
     * @return BelongsTo<Character, Field>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, Field>
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }
}
