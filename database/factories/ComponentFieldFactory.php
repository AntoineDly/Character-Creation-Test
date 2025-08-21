<?php

declare(strict_types=1);

namespace Database\Factories;

use App\ComponentFields\Domain\Models\ComponentField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComponentField>
 */
final class ComponentFieldFactory extends Factory
{
    // The name of the corresponding model
    protected $model = ComponentField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->name(),
            'component_id' => $this->faker->uuid(),
            'parameter_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
