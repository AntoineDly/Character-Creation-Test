<?php

declare(strict_types=1);

namespace Database\Factories;

use App\DefaultComponentFields\Models\DefaultComponentField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DefaultComponentField>
 */
final class DefaultComponentFieldFactory extends Factory
{
    // The name of the corresponding model
    protected $model = DefaultComponentField::class;

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
