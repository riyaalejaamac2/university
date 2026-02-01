<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();

        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_attendance' => Attendance::count(),
            'students_by_semester' => Student::selectRaw('semester, count(*) as count')
                ->groupBy('semester')
                ->orderBy('semester')
                ->get(),
            'recent_attendances' => Attendance::with(['student', 'course'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('dashboard', compact('stats', 'settings'));
    }
}
