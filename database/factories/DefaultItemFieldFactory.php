<?php

declare(strict_types=1);

namespace Database\Factories;

use App\DefaultItemFields\Models\DefaultItemField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DefaultItemField>
 */
final class DefaultItemFieldFactory extends Factory
{
    // The name of the corresponding model
    protected $model = DefaultItemField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->name(),
            'item_id' => $this->faker->uuid(),
            'parameter_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
