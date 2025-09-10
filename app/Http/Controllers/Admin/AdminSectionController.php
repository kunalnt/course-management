<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class AdminSectionController extends Controller
{
    public function index(Course $course)
    {
        $sections = $course->sections;
        return view('admin.sections.index', compact('course','sections'));
    }

    public function create(Course $course)
    {
        return view('admin.sections.create', compact('course'));
    }

    // app/Http/Controllers/AdminSectionController.php

public function store(Request $request, Course $course)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'max_seats' => 'required|integer|min:0',
    ]);

    // current sum of section capacities for this course
    $currentSum = $course->sections()->sum('max_seats');

    //dd($currentSum);

    if ($currentSum + $data['max_seats'] > $course->seat_limit) {
        return back()->with('error', 'Cannot add section. Total section seats would exceed course max seats (' . $course->seat_limit . ').');
    }

    $course->sections()->create($data);

    return redirect()->route('admin.courses.sections.index', $course->id)
        ->with('success', 'Section created for course: ' . $course->name);
}



    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    
public function update(Request $request, Section $section)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'max_seats' => 'required|integer|min:0',
    ]);

    // sum of other sections (exclude current section)
    $currentSumExcluding = $section->course->sections()
        ->where('id', '!=', $section->id)
        ->sum('max_seats');

    if ($currentSumExcluding + $data['max_seats'] > $section->course->max_seats) {
        return back()->with('error', 'Cannot update section. Total section seats would exceed course max seats (' . $section->course->max_seats . ').');
    }

    $section->update($data);

    return redirect()->route('admin.courses.sections.index', $section->course->id)
        ->with('success', 'Section updated.');
}

    public function destroy(Section $section)
    {
        $section->delete();
        return back()->with('success','Section deleted');
    }
}


?>