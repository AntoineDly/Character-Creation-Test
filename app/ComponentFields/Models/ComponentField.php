<?php

declare(strict_types=1);

namespace App\ComponentFields\Models;

use App\Components\Models\Component;
use App\Parameters\Models\Parameter;
use App\Shared\Fields\Enums\TypeFieldEnum;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\ComponentFieldFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ComponentField extends Model implements FieldInterface
{
    /** @use HasModelFactory<ComponentFieldFactory> */
    use HasModelFactory, Uuid;

    protected $fillable = [
        'value',
        'component_id',
        'parameter_id',
        'user_id',
    ];

    /**
     * Get the user that created the component.
     *
     * @return BelongsTo<User, ComponentField>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the component of the field.
     *
     * @return BelongsTo<Component, ComponentField>
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get the parameter of the field.
     *
     * @return BelongsTo<Parameter, ComponentField>
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
        return TypeFieldEnum::COMPONENT_FIELD;
    }
}
