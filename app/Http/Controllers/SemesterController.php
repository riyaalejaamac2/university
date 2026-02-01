<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::withCount(['students', 'courses'])
            ->orderBy('academic_year', 'desc')
            ->orderBy('name')
            ->orderBy('group')
            ->get();

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('semesters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group' => 'required|in:A,B,None',
            'academic_year' => 'required|string|max:20',
        ]);

        Semester::create($validated);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester created successfully.');
    }

    public function show(Semester $semester)
    {
        $students = $semester->students()->orderBy('fullname')->paginate(15);
        $courses = $semester->courses()->orderBy('course_name')->get();

        return view('semesters.show', compact('semester', 'students', 'courses'));
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group' => 'required|in:A,B,None',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive'
        ]);

        $semester->update($validated);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester updated successfully.');
    }

    public function destroy(Semester $semester)
    {
        if ($semester->students()->count() > 0 || $semester->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete semester with attached students or courses.');
        }

        $semester->delete();
        return back()->with('success', 'Semester deleted.');
    }

    public function toggleStatus(Semester $semester)
    {
        $semester->status = $semester->status === 'Active' ? 'Inactive' : 'Active';
        $semester->save();

        return back()->with('success', 'Semester status updated.');
    }
}
