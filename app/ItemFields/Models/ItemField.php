<?php

declare(strict_types=1);

namespace App\ItemFields\Models;

use App\Items\Models\Item;
use App\Parameters\Models\Parameter;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\ItemFieldFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ItemField extends Model implements FieldInterface
{
    /** @use HasModelFactory<ItemFieldFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'value',
        'item_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the item.
     *
     * @return BelongsTo<User, ItemField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the item of the field.
     *
     * @return BelongsTo<Item, ItemField>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, ItemField>
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
        return TypeFieldEnum::ITEM_FIELD;
    }
}
