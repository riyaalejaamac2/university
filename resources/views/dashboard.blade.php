@extends('layouts.app')

@section('title', 'Dashboard - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
        <p class="text-muted">Welcome to {{ $settings->university_name ?? 'University' }} Attendance Management System</p>
    </div>

    <div class="row">
        <!-- Total Students -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem; font-weight: 700;">Total
                                Students</h6>
                            <h2 class="mb-0" style="font-weight: 700;">{{ $stats['total_students'] }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-people-fill"
                                style="font-size: 2rem; color: var(--info-color); opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem; font-weight: 700;">Total
                                Courses</h6>
                            <h2 class="mb-0" style="font-weight: 700;">{{ $stats['total_courses'] }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-book-fill"
                                style="font-size: 2rem; color: var(--success-color); opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Attendance Records -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem; font-weight: 700;">
                                Attendance Records</h6>
                            <h2 class="mb-0" style="font-weight: 700;">{{ $stats['total_attendance'] }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-calendar-check-fill"
                                style="font-size: 2rem; color: var(--warning-color); opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Semester -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem; font-weight: 700;">Current
                                Semester</h6>
                            <h2 class="mb-0" style="font-weight: 700;">{{ $settings->current_semester ?? '1' }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-mortarboard-fill"
                                style="font-size: 2rem; color: var(--primary-color); opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Students by Semester -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-fill me-2"></i>Students by Semester
                </div>
                <div class="card-body">
                    @if($stats['students_by_semester']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Semester</th>
                                        <th>Number of Students</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['students_by_semester'] as $item)
                                        <tr>
                                            <td><strong>Semester {{ $item->semester }}</strong></td>
                                            <td>{{ $item->count }}</td>
                                            <td>
                                                @php
                                                    $percentage = $stats['total_students'] > 0 ? round(($item->count / $stats['total_students']) * 100, 1) : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No students registered yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>Recent Attendance Records
                </div>
                <div class="card-body">
                    @if($stats['recent_attendances']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_attendances'] as $attendance)
                                        <tr>
                                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                                            <td>{{ $attendance->student->fullname }}</td>
                                            <td>{{ $attendance->course->course_name }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $attendance->status === 'Present' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $attendance->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No attendance records yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('students.create') }}" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-person-plus-fill me-2"></i>Add Student
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('courses.create') }}" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-book me-2"></i>Add Course
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('attendances.create') }}" class="btn btn-warning w-100 mb-2">
                                <i class="bi bi-calendar-check me-2"></i>Take Attendance
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin" class="btn btn-dark w-100 mb-2">
                                <i class="bi bi-shield-lock-fill me-2"></i>Admin Area
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection