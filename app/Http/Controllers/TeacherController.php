<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with(['user', 'courses'])
            ->latest()
            ->paginate(15);
        
        return Inertia::render('teachers/index', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('teachers/create');
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
            'employee_id' => 'required|string|unique:teachers,employee_id',
            'department' => 'required|string|max:255',
            'subject_specialization' => 'required|string|max:255',
            'hire_date' => 'required|date',
        ]);

        $teacherRole = Role::where('name', 'teacher')->first();
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Default password
            'role_id' => $teacherRole->id,
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $validated['employee_id'],
            'department' => $validated['department'],
            'subject_specialization' => $validated['subject_specialization'],
            'hire_date' => $validated['hire_date'],
        ]);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'courses.students.user']);
        
        return Inertia::render('teachers/show', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        
        return Inertia::render('teachers/edit', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'employee_id' => 'required|string|unique:teachers,employee_id,' . $teacher->id,
            'department' => 'required|string|max:255',
            'subject_specialization' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $teacher->update([
            'employee_id' => $validated['employee_id'],
            'department' => $validated['department'],
            'subject_specialization' => $validated['subject_specialization'],
            'hire_date' => $validated['hire_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete(); // This will cascade delete the teacher record
        
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}