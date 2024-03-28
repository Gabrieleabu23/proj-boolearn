<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake() -> sentence(3),
            'description' => fake() -> paragraph(),
            'email' => fake() -> safeEmail(),
            'date_of_review' => fake() -> dateTimeBetween('-1 year', 'now'),
        ];
    }
}
