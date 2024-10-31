<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Items\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
final class ItemFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'component_id' => $this->faker->uuid(),
            'category_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
