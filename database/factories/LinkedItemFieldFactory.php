<?php

declare(strict_types=1);

namespace Database\Factories;

use App\LinkedItemFields\Domain\Models\LinkedItemField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LinkedItemField>
 */
final class LinkedItemFieldFactory extends Factory
{
    // The name of the corresponding model
    protected $model = LinkedItemField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->name(),
            'linked_item_id' => $this->faker->uuid(),
            'parameter_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
