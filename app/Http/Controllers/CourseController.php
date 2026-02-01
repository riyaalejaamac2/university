<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('semesterInfo');

        // Filter by semester_id
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        // Search by course name or teacher name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                    ->orWhere('teacher_name', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('course_name')->paginate(15);
        $semesters = Semester::orderBy('name')->get();

        return view('courses.index', compact('courses', 'semesters'));
    }

    public function create()
    {
        $semesters = Semester::where('status', 'Active')->get();
        return view('courses.create', compact('semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
            'semester_id' => 'required|exists:semesters,id',
            'description' => 'nullable|string',
        ]);

        $course = new Course($validated);
        $course->save();

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $semesters = Semester::where('status', 'Active')->orWhere('id', $course->semester_id)->get();
        return view('courses.edit', compact('course', 'semesters'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
            'semester_id' => 'required|exists:semesters,id',
            'description' => 'nullable|string',
        ]);

        $course->fill($validated);
        $course->save();

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
