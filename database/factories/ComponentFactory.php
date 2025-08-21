<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Components\Domain\Models\Component;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Component>
 */
final class ComponentFactory extends Factory
{
    // The name of the corresponding model
    protected $model = Component::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->uuid(),
        ];
    }
}
