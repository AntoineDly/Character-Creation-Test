<?php

declare(strict_types=1);

namespace App\Fields\Models;

use App\Base\Traits\Uuid;
use App\Parameters\Models\Parameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Field extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
        'value',
        'item_character_id',
        'parameter_id',
    ];

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
