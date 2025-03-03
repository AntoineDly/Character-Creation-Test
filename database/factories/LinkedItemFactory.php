<?php

declare(strict_types=1);

namespace Database\Factories;

use App\LinkedItems\Models\LinkedItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LinkedItem>
 */
final class LinkedItemFactory extends Factory
{
    // The name of the corresponding model
    protected $model = LinkedItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'playable_item_id' => $this->faker->uuid(),
            'character_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
