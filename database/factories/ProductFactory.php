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
            'fk_category_id' => \App\Models\Category::factory(),
            'product_name' => $this->faker->word(),
            'product_ref' => $this->faker->unique()->word(),
            'slug' => $this->faker->unique()->slug(),
            'fk_brand_id' => \App\Models\Brand::factory(),
            'genre' => $this->faker->randomElement(['Male', 'Female', 'Unisex']),
            'fk_color_id' => \App\Models\Color::factory(),
            'fk_material_id' => \App\Models\Material::factory(),
            'uv_protection' => $this->faker->boolean(),
            'water_resistance' => $this->faker->numberBetween(0, 50),
            'size' => $this->faker->numberBetween(30, 50),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'main_image' => $this->faker->imageUrl(640, 480, 'fashion', true, 'Product', true),
        ];
    }
}
