<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentUser;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles first
        $this->call(RoleSeeder::class);
        
        $adminRole = Role::where('name', 'admin')->first();
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();
        $parentRole = Role::where('name', 'parent')->first();

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'role_id' => $adminRole->id,
        ]);

        // Create teachers
        $teachers = User::factory()->count(5)->create([
            'role_id' => $teacherRole->id,
        ]);

        foreach ($teachers as $teacherUser) {
            Teacher::factory()->create([
                'user_id' => $teacherUser->id,
            ]);
        }

        // Create courses and assign to teachers
        $teacherRecords = Teacher::with('user')->get();
        $courses = [];
        foreach ($teacherRecords as $teacher) {
            $coursesForTeacher = Course::factory()->count(2)->create([
                'teacher_id' => $teacher->id,
            ]);
            $courses = array_merge($courses, $coursesForTeacher->toArray());
        }

        // Create students
        $students = User::factory()->count(20)->create([
            'role_id' => $studentRole->id,
        ]);

        $studentRecords = [];
        foreach ($students as $studentUser) {
            $studentRecord = Student::factory()->create([
                'user_id' => $studentUser->id,
            ]);
            $studentRecords[] = $studentRecord;
        }

        // Create parents
        $parents = User::factory()->count(10)->create([
            'role_id' => $parentRole->id,
        ]);

        $parentRecords = [];
        foreach ($parents as $parentUser) {
            $parentRecord = ParentUser::factory()->create([
                'user_id' => $parentUser->id,
            ]);
            $parentRecords[] = $parentRecord;
        }

        // Create parent-student relationships
        foreach ($parentRecords as $parent) {
            $childrenCount = random_int(1, 3);
            $children = collect($studentRecords)->random($childrenCount);
            
            foreach ($children as $child) {
                $parent->children()->attach($child->id, [
                    'relationship' => collect(['father', 'mother', 'guardian'])->random(),
                ]);
            }
        }

        // Create enrollments
        $courseRecords = Course::all();
        foreach ($studentRecords as $student) {
            $coursesToEnroll = $courseRecords->random(random_int(3, 6));
            
            foreach ($coursesToEnroll as $course) {
                $enrollment = Enrollment::factory()->create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ]);

                // Create grades for enrolled students
                for ($i = 0; $i < random_int(3, 8); $i++) {
                    Grade::factory()->create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                    ]);
                }

                // Create attendance records
                for ($i = 0; $i < random_int(10, 30); $i++) {
                    Attendance::factory()->create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                    ]);
                }
            }
        }

        // Create test users for each role
        User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@school.com',
            'role_id' => $teacherRole->id,
        ])->teacher()->create([
            'employee_id' => 'EMP001',
            'department' => 'Mathematics',
            'subject_specialization' => 'Algebra',
            'hire_date' => now()->subYears(2),
        ]);

        $testStudentUser = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@school.com',
            'role_id' => $studentRole->id,
        ]);
        
        $testStudent = Student::factory()->create([
            'user_id' => $testStudentUser->id,
            'student_id' => 'STU001',
            'grade_level' => '11',
        ]);

        $testParentUser = User::factory()->create([
            'name' => 'Test Parent',
            'email' => 'parent@school.com',
            'role_id' => $parentRole->id,
        ]);
        
        $testParent = ParentUser::factory()->create([
            'user_id' => $testParentUser->id,
        ]);

        // Link test parent to test student
        $testParent->children()->attach($testStudent->id, [
            'relationship' => 'father',
        ]);
    }
}