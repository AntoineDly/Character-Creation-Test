<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Models;

use App\Components\Models\Component;
use App\Fields\Models\FieldInterface;
use App\Parameters\Models\Parameter;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DefaultComponentField extends Model implements FieldInterface
{
    use Uuid;

    protected $fillable = [
        'value',
        'component_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the component.
     *
     * @return BelongsTo<User, DefaultComponentField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the component of the field.
     *
     * @return BelongsTo<Component, DefaultComponentField>
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, DefaultComponentField>
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
