<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function fake;

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
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'url' => fake()->unique()->url(),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'author' => fake()->name(),
            'cover_url' => fake()->imageUrl(),
            'source' => fake()->sentence(2),
            'provider' => AbstractProvider::class,
        ];
    }
}
