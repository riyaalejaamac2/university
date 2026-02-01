<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Setting;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'course', 'semesterInfo']);

        // Filter by semester
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->latest('date')->paginate(20);

        $courseQuery = Course::orderBy('course_name');
        if ($request->filled('semester_id')) {
            $courseQuery->where('semester_id', $request->semester_id);
        }
        $courses = $courseQuery->get();

        $semesters = Semester::orderBy('name')->get();

        return view('attendances.index', compact('attendances', 'courses', 'semesters'));
    }

    public function create(Request $request)
    {
        $settings = Setting::getSettings();

        // Check if attendance is open
        if ($settings->attendance_status === 'Closed') {
            return redirect()->route('attendances.index')
                ->with('error', 'Attendance recording is currently closed.');
        }

        $courseId = $request->get('course_id');
        $semesterId = $request->get('semester_id');
        $students = [];
        $selectedCourse = null;

        // Fetch courses - if semester is selected, only show courses for that semester
        $courseQuery = Course::with('semesterInfo')->orderBy('course_name');
        if ($semesterId) {
            $courseQuery->where('semester_id', $semesterId);
        }
        $allCourses = $courseQuery->get();

        if ($courseId) {
            $selectedCourse = Course::with('semesterInfo')->find($courseId);

            // Link Course and Semester: 
            // If no semester is explicitly selected in Step 2 yet, 
            // default to the course's assigned semester.
            if (!$semesterId && $selectedCourse && $selectedCourse->semester_id) {
                $semesterId = $selectedCourse->semester_id;

                // Re-fetch courses for updated semester context if needed
                $allCourses = Course::where('semester_id', $semesterId)->orderBy('course_name')->get();
            }
        }

        if ($courseId && $semesterId) {
            // Further Linkage: Only show students belonging to the SELECTED semester
            $students = Student::where('semester_id', $semesterId)
                ->orderBy('fullname')
                ->get();
        }

        $allSemesters = Semester::where('status', 'Active')->orderBy('name')->get();

        return view('attendances.create', [
            'courseId' => $courseId,
            'semesterId' => $semesterId,
            'students' => $students,
            'allCourses' => $allCourses,
            'allSemesters' => $allSemesters,
            'selectedCourse' => $selectedCourse
        ]);
    }

    public function store(Request $request)
    {
        $settings = Setting::getSettings();

        // Check if attendance is open
        if ($settings->attendance_status === 'Closed') {
            return redirect()->route('attendances.index')
                ->with('error', 'Attendance recording is currently closed.');
        }

        $validated = $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'course_id' => 'required|exists:courses,id',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:Present,Absent',
        ]);

        $date = now()->toDateString();

        DB::beginTransaction();
        try {
            foreach ($validated['attendances'] as $attendance) {
                // Check if attendance already exists
                $exists = Attendance::where('student_id', $attendance['student_id'])
                    ->where('course_id', $validated['course_id'])
                    ->whereDate('date', $date)
                    ->exists();

                if (!$exists) {
                    Attendance::create([
                        'student_id' => $attendance['student_id'],
                        'course_id' => $validated['course_id'],
                        'semester_id' => $validated['semester_id'],
                        'academic_year' => $settings->academic_year,
                        'date' => $date,
                        'status' => $attendance['status'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('attendances.index')
                ->with('success', 'Attendance recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error recording attendance: ' . $e->getMessage());
        }
    }

    public function edit(Attendance $attendance)
    {
        return view('attendances.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:Present,Absent'
        ]);

        $attendance->update(['status' => $validated['status']]);

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance record updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance record deleted successfully.');
    }
}
