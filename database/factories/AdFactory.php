<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'address' => $this->faker->address,
            'price' => $this->faker->numberBetween(100, 1000),
            'rooms' => $this->faker->numberBetween(1, 5),
            'square' => $this->faker->numberBetween(50, 200),
            'user_id' => 1,
            'branch_id' => 1,
            'status_id' => 1,
            'description' => $this->faker->paragraph,
        ];
    }
}
