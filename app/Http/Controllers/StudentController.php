<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

use App\Models\Semester;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('semesterInfo');

        // Filter by semester_id
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Search by name or student_id
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('fullname')->paginate(15);
        $departments = Student::distinct()->pluck('department');
        $semesters = Semester::whereIn('status', ['Active', 'Inactive'])->orderBy('name')->get();

        return view('students.index', compact('students', 'departments', 'semesters'));
    }

    public function create()
    {
        $semesters = Semester::where('status', 'Active')->get();
        return view('students.create', compact('semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'semester_id' => 'required|exists:semesters,id',
            'department' => 'required|string|max:255',
        ]);

        $student = new Student($validated);
        $student->save();

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $semesters = Semester::where('status', 'Active')->orWhere('id', $student->semester_id)->get();
        return view('students.edit', compact('student', 'semesters'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'semester_id' => 'required|exists:semesters,id',
            'department' => 'required|string|max:255',
        ]);

        $student->fill($validated);
        $student->save();

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
