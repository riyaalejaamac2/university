<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index()
    {
        // Get counts of students in each semester
        $semesters = Semester::withCount('students')->orderBy('name')->get();
        return view('promotion.index', compact('semesters'));
    }

    public function promote(Request $request)
    {
        $validated = $request->validate([
            'from_semester_id' => 'required|exists:semesters,id',
            'to_semester_id' => 'required|exists:semesters,id|different:from_semester_id',
        ]);

        $fromId = $validated['from_semester_id'];
        $toId = $validated['to_semester_id'];

        $count = Student::where('semester_id', $fromId)->count();

        if ($count === 0) {
            return redirect()->back()->with('error', "No students found in the selected source semester.");
        }

        // Update students
        Student::where('semester_id', $fromId)
            ->update(['semester_id' => $toId]);

        return redirect()->route('promotion.index')
            ->with('success', "Successfully promoted $count students.");
    }
}
