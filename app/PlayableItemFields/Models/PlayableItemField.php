<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Models;

use App\Parameters\Models\Parameter;
use App\PlayableItems\Models\PlayableItem;
use App\Shared\Fields\Enums\TypeFieldEnum;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\PlayableItemFieldFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PlayableItemField extends Model implements FieldInterface
{
    /** @use HasModelFactory<PlayableItemFieldFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'value',
        'playable_item_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the playableItem.
     *
     * @return BelongsTo<User, PlayableItemField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the playableItem of the field.
     *
     * @return BelongsTo<PlayableItem, PlayableItemField>
     */
    public function playableItem(): BelongsTo
    {
        return $this->belongsTo(PlayableItem::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, PlayableItemField>
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
        return TypeFieldEnum::PLAYABLE_ITEM_FIELD;
    }
}
