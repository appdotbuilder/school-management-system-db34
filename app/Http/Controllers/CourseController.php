<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['teacher.user', 'students'])
            ->latest()
            ->paginate(15);
        
        return Inertia::render('courses/index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->active()->get();
        
        return Inertia::render('courses/create', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'grade_level' => 'required|string',
            'credits' => 'required|integer|min:1|max:6',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['teacher.user', 'students.user', 'grades', 'attendanceRecords']);
        
        return Inertia::render('courses/show', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers = Teacher::with('user')->active()->get();
        
        return Inertia::render('courses/edit', [
            'course' => $course,
            'teachers' => $teachers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'grade_level' => 'required|string',
            'credits' => 'required|integer|min:1|max:6',
            'teacher_id' => 'nullable|exists:teachers,id',
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}