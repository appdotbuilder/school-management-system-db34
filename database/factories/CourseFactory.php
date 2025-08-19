<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Mathematics' => ['MATH101', 'MATH201', 'MATH301'],
            'Science' => ['SCI101', 'SCI201', 'SCI301'],
            'English' => ['ENG101', 'ENG201', 'ENG301'],
            'History' => ['HIST101', 'HIST201', 'HIST301'],
            'Art' => ['ART101', 'ART201', 'ART301'],
        ];

        $subject = fake()->randomElement(array_keys($subjects));
        $codes = $subjects[$subject];

        return [
            'code' => fake()->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'name' => $subject . ' ' . fake()->randomElement(['Fundamentals', 'Advanced', 'Honors']),
            'description' => fake()->paragraph(),
            'grade_level' => fake()->randomElement(['9', '10', '11', '12']),
            'credits' => fake()->numberBetween(1, 4),
            'teacher_id' => Teacher::factory(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}