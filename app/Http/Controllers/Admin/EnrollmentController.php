<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Section;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Students must be logged in
    }

    /**
     * Enroll directly into a section
     */
    public function enrollSection(Request $request, Section $section)
    {
        $user = $request->user();

        return DB::transaction(function () use ($user, $section) {
            // Lock row for concurrency safety
            $s = Section::where('id', $section->id)->lockForUpdate()->first();

            if (!$s) {
                return back()->with('error', 'Section not found.');
            }

            if ($s->seats_taken >= $s->seat_capacity) {
                return back()->with('error', 'This section is full.');
            }

            // Check if already enrolled in this course
            $exists = Enrollment::where('user_id', $user->id)
                ->where('course_id', $s->course_id)
                ->exists();

            if ($exists) {
                return back()->with('error', 'You are already enrolled in this course.');
            }

            // Create enrollment
            Enrollment::create([
                'user_id'   => $user->id,
                'course_id' => $s->course_id,
                'section_id'=> $s->id,
            ]);

            // Update seats_taken
            $s->increment('seats_taken');

            return back()->with('success', 'Enrolled successfully in section: ' . $s->name);
        });
    }

    /**
     * Enroll in a course (auto-assign section with most available seats)
     */
    public function enrollCourse(Request $request, Course $course)
    {
        $user = $request->user();

        return DB::transaction(function () use ($user, $course) {
            // Check if already enrolled
            $already = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();

            if ($already) {
                return back()->with('error', 'You are already enrolled in this course.');
            }

            // Lock all sections of this course
            $sections = Section::where('course_id', $course->id)
                ->lockForUpdate()
                ->get();

            if ($sections->isEmpty()) {
                return back()->with('error', 'No sections available for this course.');
            }

            // Find section with most available seats
            $best = null;
            foreach ($sections as $s) {
                $remaining = $s->seat_capacity - $s->seats_taken;
                if ($remaining <= 0) continue;

                if (is_null($best) || $remaining > ($best->seat_capacity - $best->seats_taken)) {
                    $best = $s;
                }
            }

            if (is_null($best)) {
                return back()->with('error', 'All sections are full for this course.');
            }

            // Create enrollment
            Enrollment::create([
                'user_id'   => $user->id,
                'course_id' => $course->id,
                'section_id'=> $best->id,
            ]);

            // Increment seat count
            $best->increment('seats_taken');

            return back()->with('success', 'Enrolled into section: ' . $best->name);
        });
    }

    /**
     * Show all courses user enrolled in
     */
    public function myEnrollments(Request $request)
    {
        $user = $request->user();
        $enrollments = Enrollment::with('course', 'section')
            ->where('user_id', $user->id)
            ->get();

        return view('student.enrollments', compact('enrollments'));
    }
}
