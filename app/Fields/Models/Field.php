<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Characters\Models\Character;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Models\Parameter;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Field extends Model implements FieldInterface
{
    use Uuid;

    protected $fillable = [
        'value',
        'linked_item_id',
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
     * Get the linked item of the field.
     *
     * @return BelongsTo<LinkedItem, Field>
     */
    public function linkedItem(): BelongsTo
    {
        return $this->belongsTo(LinkedItem::class);
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getParameter(): ?Parameter
    {
        return $this->parameter;
    }
}
