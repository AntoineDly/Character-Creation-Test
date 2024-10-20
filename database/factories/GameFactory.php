<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Games\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
final class GameFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Game::class;

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
