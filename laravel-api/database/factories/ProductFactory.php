<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0,100),
            'sku' => $this->faker->unique()->ean8(),
            'category_id' => Category::factory(),
            'is_active' => true
        ];
    }
}
