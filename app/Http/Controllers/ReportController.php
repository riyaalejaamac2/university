<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function bySemester(Request $request)
    {
        $semesterId = $request->get('semester_id');

        $report = null;
        if ($semesterId) {
            $semester = Semester::findOrFail($semesterId);
            $report = [
                'semester' => $semester,
                'total_students' => Student::where('semester_id', $semesterId)->count(),
                'total_courses' => Course::where('semester_id', $semesterId)->count(),
                'total_attendances' => Attendance::where('semester_id', $semesterId)->count(),
                'present_count' => Attendance::where('semester_id', $semesterId)->where('status', 'Present')->count(),
                'absent_count' => Attendance::where('semester_id', $semesterId)->where('status', 'Absent')->count(),
                'attendances' => Attendance::with(['student', 'course'])
                    ->where('semester_id', $semesterId)
                    ->latest('date')
                    ->paginate(20),
            ];
        }

        $semesters = Semester::orderBy('name')->get();

        return view('reports.by_semester', compact('semesters', 'semesterId', 'report'));
    }

    public function byCourse(Request $request)
    {
        $courseId = $request->get('course_id');

        $course = null;
        $report = null;

        if ($courseId) {
            $course = Course::with('semesterInfo')->findOrFail($courseId);
            $attendances = Attendance::with('student')
                ->where('course_id', $courseId)
                ->latest('date')
                ->get();

            $report = [
                'course' => $course,
                'total_records' => $attendances->count(),
                'present_count' => $attendances->where('status', 'Present')->count(),
                'absent_count' => $attendances->where('status', 'Absent')->count(),
                'attendances' => $attendances,
            ];
        }

        $courses = Course::with('semesterInfo')->orderBy('course_name')->get();

        return view('reports.by_course', compact('courses', 'courseId', 'report'));
    }

    public function byStudent(Request $request)
    {
        $studentId = $request->get('student_id');

        $student = null;
        $report = null;

        if ($studentId) {
            $student = Student::with('semesterInfo')->findOrFail($studentId);
            $attendances = Attendance::with('course')
                ->where('student_id', $studentId)
                ->latest('date')
                ->get();

            $report = [
                'student' => $student,
                'total_records' => $attendances->count(),
                'present_count' => $attendances->where('status', 'Present')->count(),
                'absent_count' => $attendances->where('status', 'Absent')->count(),
                'attendances' => $attendances,
                'attendance_percentage' => $attendances->count() > 0
                    ? round(($attendances->where('status', 'Present')->count() / $attendances->count()) * 100, 2)
                    : 0,
            ];
        }

        $students = Student::with('semesterInfo')->orderBy('fullname')->get();

        return view('reports.by_student', compact('students', 'studentId', 'report'));
    }
}
