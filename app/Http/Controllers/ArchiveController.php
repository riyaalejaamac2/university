<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        // Get all unique academic years for the dropdown
        $academicYears = Attendance::distinct()
            ->whereNotNull('academic_year')
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');

        $semesters = Semester::orderBy('name')->get();

        $selectedYear = $request->get('academic_year');
        $selectedSemesterId = $request->get('semester_id');
        $searchStudent = $request->get('student_search');

        $studentStats = null;
        $studentHistory = null;
        $selectedStudent = null;

        // If a student search is performed, fetch their absolute history
        if ($searchStudent) {
            $selectedStudent = Student::where('student_id', $searchStudent)
                ->orWhere('fullname', 'like', "%{$searchStudent}%")
                ->first();

            if ($selectedStudent) {
                // Fetch historical stats consolidated by semester
                $studentHistory = Attendance::where('student_id', $selectedStudent->id)
                    ->with('semesterInfo', 'course')
                    ->select(
                        'semester_id',
                        'academic_year',
                        DB::raw('count(*) as total_days'),
                        DB::raw('sum(case when status = "Absent" then 1 else 0 end) as absent_days'),
                        DB::raw('sum(case when status = "Present" then 1 else 0 end) as present_days')
                    )
                    ->groupBy('semester_id', 'academic_year')
                    ->orderBy('academic_year', 'desc')
                    ->get();
            }
        }

        // Fetch stats for the selected filters
        if ($selectedYear && $selectedSemesterId) {
            $studentStatsQuery = Attendance::with('student')
                ->select(
                    'student_id',
                    DB::raw('count(*) as total_days'),
                    DB::raw('sum(case when status = "Absent" then 1 else 0 end) as total_absences'),
                    // Monthly breakdown using group_concat or multiple sub-selects is complex in SQLite, 
                    // so we'll fetch basic data and process in PHP for the monthly view if many students.
                    // But for now, let's get the core stats.
                )
                ->where('academic_year', $selectedYear)
                ->where('semester_id', $selectedSemesterId)
                ->groupBy('student_id');

            $studentStats = $studentStatsQuery->paginate(30);

            // Fetch monthly absence breakdown for the students in the current pagination
            foreach ($studentStats as $stat) {
                $stat->monthly_absences = Attendance::where('student_id', $stat->student_id)
                    ->where('academic_year', $selectedYear)
                    ->where('semester_id', $selectedSemesterId)
                    ->where('status', 'Absent')
                    ->select(DB::raw("strftime('%m', date) as month"), DB::raw('count(*) as count'))
                    ->groupBy('month')
                    ->pluck('count', 'month');
            }
        }

        return view('archives.index', compact(
            'academicYears',
            'semesters',
            'selectedYear',
            'selectedSemesterId',
            'studentStats',
            'studentHistory',
            'selectedStudent',
            'searchStudent'
        ));
    }
}
