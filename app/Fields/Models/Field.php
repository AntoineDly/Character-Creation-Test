<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Base\Traits\Uuid;
use App\Character\Models\Character;
use App\Items\Models\Item;
use App\Parameters\Models\Parameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Field extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'value',
        'item_id',
        'character_id',
        'parameter_id',
    ];

    /**
     * Get the item of the field.
     *
     * @return BelongsTo<Item, Field>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
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
