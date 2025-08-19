<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'courses'])
            ->latest()
            ->paginate(15);
        
        return Inertia::render('students/index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('students/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'student_id' => 'required|string|unique:students,student_id',
            'grade_level' => 'required|string',
            'enrollment_date' => 'required|date',
        ]);

        $studentRole = Role::where('name', 'student')->first();
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Default password
            'role_id' => $studentRole->id,
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'grade_level' => $validated['grade_level'],
            'enrollment_date' => $validated['enrollment_date'],
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'courses.teacher.user', 'grades.course', 'attendanceRecords.course']);
        
        return Inertia::render('students/show', [
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load('user');
        
        return Inertia::render('students/edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'grade_level' => 'required|string',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,inactive,graduated,transferred',
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $student->update([
            'student_id' => $validated['student_id'],
            'grade_level' => $validated['grade_level'],
            'enrollment_date' => $validated['enrollment_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete(); // This will cascade delete the student record
        
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}