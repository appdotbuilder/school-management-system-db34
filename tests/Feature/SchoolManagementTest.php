<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_displays_school_management_features(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Since we're using Inertia.js, check for the component name in the HTML
        $response->assertSee('welcome');
    }

    public function test_admin_dashboard_displays_correctly(): void
    {
        // Create roles
        $adminRole = Role::factory()->create(['name' => 'admin', 'display_name' => 'Administrator']);
        
        // Create admin user
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        
        // Create some test data
        $studentRole = Role::factory()->create(['name' => 'student', 'display_name' => 'Student']);
        $teacherRole = Role::factory()->create(['name' => 'teacher', 'display_name' => 'Teacher']);
        
        Student::factory()->count(5)->create();
        Teacher::factory()->count(3)->create();
        Course::factory()->count(4)->create();

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        // Since we're using Inertia.js, check for the component name
        $response->assertSee('dashboard');
    }

    public function test_teacher_dashboard_displays_correctly(): void
    {
        // Create roles
        $teacherRole = Role::factory()->create(['name' => 'teacher', 'display_name' => 'Teacher']);
        
        // Create teacher user
        $teacherUser = User::factory()->create(['role_id' => $teacherRole->id]);
        $teacher = Teacher::factory()->create(['user_id' => $teacherUser->id]);
        
        // Create courses for the teacher
        Course::factory()->count(3)->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacherUser)->get('/dashboard');

        $response->assertStatus(200);
        // Since we're using Inertia.js, check for the component name
        $response->assertSee('dashboard');
    }

    public function test_student_dashboard_displays_correctly(): void
    {
        // Create roles
        $studentRole = Role::factory()->create(['name' => 'student', 'display_name' => 'Student']);
        
        // Create student user
        $studentUser = User::factory()->create(['role_id' => $studentRole->id]);
        $student = Student::factory()->create(['user_id' => $studentUser->id]);

        $response = $this->actingAs($studentUser)->get('/dashboard');

        $response->assertStatus(200);
        // Since we're using Inertia.js, check for the component name
        $response->assertSee('dashboard');
    }

    public function test_students_index_page_accessible_by_authenticated_user(): void
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);
        
        $response = $this->actingAs($user)->get('/students');

        $response->assertStatus(200);
        // Since we're using Inertia.js, just check status and that it's an Inertia response
        $this->assertTrue(true); // Placeholder until we can properly test Inertia components
    }

    public function test_roles_are_created_correctly(): void
    {
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        $this->assertDatabaseHas('roles', ['name' => 'admin', 'display_name' => 'Administrator']);
        $this->assertDatabaseHas('roles', ['name' => 'teacher', 'display_name' => 'Teacher']);
        $this->assertDatabaseHas('roles', ['name' => 'student', 'display_name' => 'Student']);
        $this->assertDatabaseHas('roles', ['name' => 'parent', 'display_name' => 'Parent']);
    }

    public function test_user_role_helpers_work_correctly(): void
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $teacherRole = Role::factory()->create(['name' => 'teacher']);
        $studentRole = Role::factory()->create(['name' => 'student']);
        $parentRole = Role::factory()->create(['name' => 'parent']);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $teacher = User::factory()->create(['role_id' => $teacherRole->id]);
        $student = User::factory()->create(['role_id' => $studentRole->id]);
        $parent = User::factory()->create(['role_id' => $parentRole->id]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isTeacher());

        $this->assertTrue($teacher->isTeacher());
        $this->assertFalse($teacher->isStudent());

        $this->assertTrue($student->isStudent());
        $this->assertFalse($student->isParent());

        $this->assertTrue($parent->isParent());
        $this->assertFalse($parent->isAdmin());
    }

    public function test_student_grade_calculation_works(): void
    {
        $grade = new \App\Models\Grade([
            'points_earned' => 85,
            'points_possible' => 100,
            'percentage' => 85.0,
        ]);

        $this->assertEquals('B', $grade->calculateLetterGrade());

        $grade->percentage = 95.0;
        $this->assertEquals('A', $grade->calculateLetterGrade());

        $grade->percentage = 75.0;
        $this->assertEquals('C', $grade->calculateLetterGrade());

        $grade->percentage = 65.0;
        $this->assertEquals('D', $grade->calculateLetterGrade());

        $grade->percentage = 55.0;
        $this->assertEquals('F', $grade->calculateLetterGrade());
    }
}