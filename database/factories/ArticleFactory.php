<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'content' => $this->faker->text(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'user_id'=> "1",
            'image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['draft', 'published'])
        ];
    }
}
