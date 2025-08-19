<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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
            'employee_id' => 'EMP' . fake()->unique()->numerify('####'),
            'department' => fake()->randomElement(['Mathematics', 'Science', 'English', 'History', 'Physical Education', 'Art', 'Music']),
            'subject_specialization' => fake()->randomElement(['Algebra', 'Biology', 'Literature', 'World History', 'Chemistry', 'Physics', 'Geometry']),
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'status' => fake()->randomElement(['active', 'inactive', 'on_leave']),
        ];
    }
}