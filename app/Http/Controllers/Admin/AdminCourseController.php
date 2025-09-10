<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Show all courses
     */
    public function index()
    {
        $courses = Course::withCount('sections')->get();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show form for creating a new course
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store new course in database
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seat_limit' => 'nullable|integer|min:0'
        ]);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Show form for editing a course
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update course
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seat_limit' => 'nullable|integer|min:0'
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Delete a course
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // Show single course with sections + seat status
    public function show($id)
    {
        $course = Course::with(['sections.enrollments', 'enrollments'])->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }
}
