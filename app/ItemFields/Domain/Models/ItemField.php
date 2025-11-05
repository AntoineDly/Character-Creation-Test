<?php

declare(strict_types=1);

namespace App\ItemFields\Domain\Models;

use App\Fields\Domain\Enums\TypeFieldEnum;
use App\Fields\Domain\Interfaces\FieldInterface;
use App\Items\Domain\Models\Item;
use App\Parameters\Domain\Models\Parameter;
use App\Shared\Domain\Traits\HasModelFactory;
use App\Shared\Domain\Traits\Uuid;
use App\Users\Domain\Models\User;
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
