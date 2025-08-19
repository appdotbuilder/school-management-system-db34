<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'student_id' => 'STU' . fake()->unique()->numerify('######'),
            'grade_level' => fake()->randomElement(['9', '10', '11', '12']),
            'enrollment_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'status' => fake()->randomElement(['active', 'inactive', 'graduated', 'transferred']),
        ];
    }
}