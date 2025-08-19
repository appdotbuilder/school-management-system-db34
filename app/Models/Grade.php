<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Grade
 *
 * @property int $id
 * @property int $student_id
 * @property int $course_id
 * @property string $assignment_type
 * @property string $assignment_name
 * @property float $points_earned
 * @property float $points_possible
 * @property float $percentage
 * @property string|null $letter_grade
 * @property string $assignment_date
 * @property string|null $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\Course $course
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade query()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereAssignmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereAssignmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade wherePointsEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade wherePointsPossible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereLetterGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereAssignmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereUpdatedAt($value)
 * @method static \Database\Factories\GradeFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'assignment_type',
        'assignment_name',
        'points_earned',
        'points_possible',
        'percentage',
        'letter_grade',
        'assignment_date',
        'comments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points_earned' => 'decimal:2',
        'points_possible' => 'decimal:2',
        'percentage' => 'decimal:2',
        'assignment_date' => 'date',
    ];

    /**
     * Get the student that owns the grade.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that owns the grade.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Calculate letter grade from percentage.
     */
    public function calculateLetterGrade(): string
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
}