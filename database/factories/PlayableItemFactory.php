<?php

declare(strict_types=1);

namespace Database\Factories;

use App\PlayableItems\Domain\Models\PlayableItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayableItem>
 */
final class PlayableItemFactory extends Factory
{
    // The name of the corresponding model
    protected $model = PlayableItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => $this->faker->uuid(),
            'game_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
