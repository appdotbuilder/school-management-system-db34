<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pointsPossible = fake()->numberBetween(50, 100);
        $pointsEarned = fake()->numberBetween(0, $pointsPossible);
        $percentage = round(($pointsEarned / $pointsPossible) * 100, 2);
        
        $letterGrade = match (true) {
            $percentage >= 90 => 'A',
            $percentage >= 80 => 'B',
            $percentage >= 70 => 'C',
            $percentage >= 60 => 'D',
            default => 'F'
        };

        return [
            'student_id' => Student::factory(),
            'course_id' => Course::factory(),
            'assignment_type' => fake()->randomElement(['quiz', 'test', 'assignment', 'project', 'homework']),
            'assignment_name' => fake()->sentence(3),
            'points_earned' => $pointsEarned,
            'points_possible' => $pointsPossible,
            'percentage' => $percentage,
            'letter_grade' => $letterGrade,
            'assignment_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'comments' => fake()->optional()->sentence(),
        ];
    }
}