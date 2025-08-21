<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Domain\Models;

use App\Characters\Domain\Models\Character;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\Parameters\Domain\Models\Parameter;
use App\Shared\Fields\Enums\TypeFieldEnum;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Domain\Models\User;
use Database\Factories\LinkedItemFieldFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class LinkedItemField extends Model implements FieldInterface
{
    /** @use HasModelFactory<LinkedItemFieldFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'value',
        'linked_item_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the component.
     *
     * @return BelongsTo<User, LinkedItemField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the linked item of the field.
     *
     * @return BelongsTo<LinkedItem, LinkedItemField>
     */
    public function linkedItem(): BelongsTo
    {
        return $this->belongsTo(LinkedItem::class);
    }

    /**
     * Get the character of the field.
     *
     * @return BelongsTo<Character, LinkedItemField>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, LinkedItemField>
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getParameter(): ?Parameter
    {
        return $this->parameter;
    }

    public function getType(): TypeFieldEnum
    {
        return TypeFieldEnum::LINKED_ITEM_FIELD;
    }
}
