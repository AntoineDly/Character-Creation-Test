<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Models;

use App\Fields\Models\FieldInterface;
use App\Items\Models\Item;
use App\Parameters\Models\Parameter;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DefaultItemField extends Model implements FieldInterface
{
    use Uuid;

    protected $fillable = [
        'value',
        'item_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the item.
     *
     * @return BelongsTo<User, DefaultItemField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the item of the field.
     *
     * @return BelongsTo<Item, DefaultItemField>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, DefaultItemField>
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
}
