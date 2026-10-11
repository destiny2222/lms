<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'designation' => fake()->jobTitle().' at '.fake()->company(),
            'content' => fake()->paragraph(),
            'image' => null,
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
