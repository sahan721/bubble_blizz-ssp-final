<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
        {
            return [
                'name' => $this->faker->words(2, true),
                'category' => $this->faker->randomElement([
                    'soft-drinks', 'juices', 'dairy', 'energy-drinks'
                ]),
                'description' => $this->faker->optional()->sentence(12),
                'price' => $this->faker->randomFloat(2, 50, 5000),
                'stock' => $this->faker->numberBetween(0, 200),
                'image' => $this->faker->optional()->imageUrl(640, 640, 'food', true),
            ];
        }

}
