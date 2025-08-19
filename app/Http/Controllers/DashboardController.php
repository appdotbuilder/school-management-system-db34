<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $dashboardData = [
            'user' => $user->load('role'),
        ];

        // Admin dashboard data
        if ($user->isAdmin()) {
            $dashboardData = array_merge($dashboardData, [
                'stats' => [
                    'total_students' => Student::active()->count(),
                    'total_teachers' => Teacher::active()->count(),
                    'total_courses' => Course::active()->count(),
                    'total_users' => User::count(),
                ],
                'recent_enrollments' => Student::with(['user', 'courses'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ]);
        }

        // Teacher dashboard data
        elseif ($user->isTeacher()) {
            $teacher = $user->teacher;
            if ($teacher) {
                $courses = Course::where('teacher_id', $teacher->id)
                    ->with(['students.user'])
                    ->get();
                
                $dashboardData = array_merge($dashboardData, [
                    'teacher' => $teacher,
                    'courses' => $courses,
                    'stats' => [
                        'total_courses' => $courses->count(),
                        'total_students' => $courses->sum(fn($course) => $course->students->count()),
                        'pending_grades' => 0, // Can be calculated based on recent assignments
                    ],
                ]);
            }
        }

        // Student dashboard data
        elseif ($user->isStudent()) {
            $student = $user->student;
            if ($student) {
                $courses = $student->courses()->with(['teacher.user'])->get();
                $recentGrades = Grade::where('student_id', $student->id)
                    ->with('course')
                    ->latest()
                    ->take(5)
                    ->get();
                
                $dashboardData = array_merge($dashboardData, [
                    'student' => $student,
                    'courses' => $courses,
                    'recent_grades' => $recentGrades,
                    'stats' => [
                        'enrolled_courses' => $courses->count(),
                        'gpa' => $this->calculateGPA($student->id),
                        'attendance_rate' => $this->calculateAttendanceRate($student->id),
                    ],
                ]);
            }
        }

        // Parent dashboard data
        elseif ($user->isParent()) {
            $parent = $user->parent;
            if ($parent) {
                $children = $parent->children()->with(['user', 'courses.teacher.user'])->get();
                
                $dashboardData = array_merge($dashboardData, [
                    'parent' => $parent,
                    'children' => $children,
                    'stats' => [
                        'total_children' => $children->count(),
                    ],
                ]);
            }
        }

        return Inertia::render('dashboard', $dashboardData);
    }

    /**
     * Calculate GPA for a student.
     */
    protected function calculateGPA(int $studentId): float
    {
        $grades = Grade::where('student_id', $studentId)->get();
        
        if ($grades->isEmpty()) {
            return 0.0;
        }

        $totalPoints = 0;
        $totalCredits = 0;

        foreach ($grades as $grade) {
            $gradePoints = $this->getGradePoints($grade->letter_grade ?? $grade->calculateLetterGrade());
            $credits = $grade->course->credits ?? 1;
            
            $totalPoints += $gradePoints * $credits;
            $totalCredits += $credits;
        }

        return $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0.0;
    }

    /**
     * Get grade points for letter grade.
     */
    protected function getGradePoints(string $letterGrade): float
    {
        return match ($letterGrade) {
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
            default => 0.0,
        };
    }

    /**
     * Calculate attendance rate for a student.
     */
    protected function calculateAttendanceRate(int $studentId): float
    {
        $totalAttendance = Attendance::where('student_id', $studentId)->count();
        $presentAttendance = Attendance::where('student_id', $studentId)
            ->whereIn('status', ['present', 'excused'])
            ->count();

        return $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 1) : 100.0;
    }
}