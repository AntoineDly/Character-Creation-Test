<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Base\Traits\Uuid;
use App\Items\Models\Item;
use App\Parameters\Models\Parameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DefaultField extends Model
{
    use Uuid;

    protected $fillable = [
        'value',
        'item_id',
        'parameter_id',
    ];

    /**
     * Get the item of the field.
     *
     * @return BelongsTo<Item, DefaultField>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, DefaultField>
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }
}
