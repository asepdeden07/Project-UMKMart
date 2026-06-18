<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10000, 1000000),
            'stock' => fake()->numberBetween(5, 100),
            'image' => 'products/sample-' . fake()->uuid() . '.jpg', // Dummy path
        ];
    }
}
