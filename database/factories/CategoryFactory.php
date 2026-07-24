<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $slug = fake()->slug();

        return [
            'name' => ucfirst($name),
            'slug' => $slug,
            'description' => fake()->sentence(),
            'image' => null,
            'is_active' => true,
        ];
    }
}
