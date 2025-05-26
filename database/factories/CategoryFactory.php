<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => $this->faker->unique(), 
            'slug' => $this->faker->unique()->slug(),   
            'main_image' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),    
        ];
    }
}
