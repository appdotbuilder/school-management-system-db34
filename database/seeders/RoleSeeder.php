<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access and user management',
            ],
            [
                'name' => 'teacher',
                'display_name' => 'Teacher',
                'description' => 'Course management, grading, and attendance tracking',
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'View courses, grades, and attendance',
            ],
            [
                'name' => 'parent',
                'display_name' => 'Parent',
                'description' => 'View child grades and attendance',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}