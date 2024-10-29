<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Parameter>
 */
final class ParameterFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Parameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'user_id' => $this->faker->uuid(),
            'type' => $this->faker->randomElement(TypeParameterEnum::cases()),
        ];
    }
}
