<?php

declare(strict_types=1);

namespace Database\Factories;

use App\PlayableItemFields\Domain\Models\PlayableItemField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayableItemField>
 */
final class PlayableItemFieldFactory extends Factory
{
    // The name of the corresponding model
    protected $model = PlayableItemField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->name(),
            'playable_item_id' => $this->faker->uuid(),
            'parameter_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
