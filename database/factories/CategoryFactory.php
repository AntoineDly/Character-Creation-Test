<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Categories\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
final class CategoryFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Category::class;

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
        ];
    }
}
