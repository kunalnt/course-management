<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Show student dashboard
    public function index()
    {
        // Eager load sections + enrollments
        $courses = Course::with(['sections.enrollments','enrollments'])->get();

        return view('student.dashboard', compact('courses'));
    }

    // Enroll in course (auto section assignment)
    public function enrollCourse(Request $request, Course $course)
    {
        $user = $request->user();

        return DB::transaction(function() use ($user, $course) {

            // Lock course & sections for update
            $course = Course::with('sections.enrollments')->lockForUpdate()->find($course->id);

            $totalEnroll = $course->enrollments->count();
            $maxSeats = (int)$course->seat_limit;

            if($totalEnroll >= $maxSeats){
                return back()->with('error','Course full.');
            }

            if(Enrollment::where('user_id',$user->id)->where('course_id',$course->id)->exists()){
                return back()->with('error','Already enrolled in this course.');
            }

            // Find section with most available seats
            $bestSection = null;
            $bestRemaining = -1;
            foreach($course->sections as $section){
                $filled = $section->enrollments->count();
                $remaining = (int)$section->max_seats - $filled;

                if($remaining > $bestRemaining){
                    $bestRemaining = $remaining;
                    $bestSection = $section;
                }
            }

            if(!$bestSection || $bestRemaining <= 0){
                return back()->with('error','All sections full.');
            }

            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'section_id' => $bestSection->id
            ]);

            return back()->with('success','Enrolled in section: '.$bestSection->name);
        });
    }

    // Enroll in specific section
    public function enrollSection(Request $request, Section $section)
    {
        $user = $request->user();

        return DB::transaction(function() use ($user, $section){

            $s = Section::with('course','enrollments')->lockForUpdate()->find($section->id);

            if(!$s) return back()->with('error','Section not found.');

            $course = $s->course;

            // Check course total seats
            $totalCourseEnroll = $course->enrollments()->count();
            $courseMax = (int)$course->seat_limit;
            if($totalCourseEnroll >= $courseMax){
                return back()->with('error','Course full.');
            }

            // Check section seats
            $filledSection = $s->enrollments->count();
            $sectionMax = (int)$s->max_seats;
            if($filledSection >= $sectionMax){
                return back()->with('error','Section full.');
            }

            // Check if student already enrolled in course
            if(Enrollment::where('user_id',$user->id)->where('course_id',$s->course_id)->exists()){
                return back()->with('error','Already enrolled in this course.');
            }

            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $s->course_id,
                'section_id' => $s->id
            ]);

            return back()->with('success','Enrolled in section: '.$s->name);
        });
    }

    // My Enrollments page
    public function myEnrollments(Request $request)
    {
        $enrollments = $request->user()->enrollments()->with('course','section')->get();
        return view('student.enrollments', compact('enrollments'));
    }
}
