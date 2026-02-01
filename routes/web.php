<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// The System Dashboard is now the ROOT page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Redirect old dashboard URL to root
Route::get('/dashboard', function () {
    return redirect('/');
});

// All System Portal routes are now PUBLIC
Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('attendances', AttendanceController::class);

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/semester', [ReportController::class, 'bySemester'])->name('reports.semester');
Route::get('/reports/course', [ReportController::class, 'byCourse'])->name('reports.course');
Route::get('/reports/student', [ReportController::class, 'byStudent'])->name('reports.student');

Route::resource('semesters', SemesterController::class);
Route::patch('/semesters/{semester}/status', [SemesterController::class, 'toggleStatus'])->name('semesters.toggle');

Route::get('/promotion', [PromotionController::class, 'index'])->name('promotion.index');
Route::post('/promotion', [PromotionController::class, 'promote'])->name('promotion.store');

Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
