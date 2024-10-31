<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Characters\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Character>
 */
final class CharacterFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
        ];
    }
}
