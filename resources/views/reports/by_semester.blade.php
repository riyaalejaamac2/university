@extends('layouts.app')

@section('title', 'Attendance Report by Semester - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-bar-chart-fill me-2"></i>Attendance Report by Semester</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">By Semester</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            Select Semester
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.semester') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="semester_id" class="form-label">Semester</label>
                    <select name="semester_id" id="semester_id" class="form-select" required>
                        <option value="">Choose Semester...</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem->id }}" {{ $semesterId == $sem->id ? 'selected' : '' }}>
                                {{ $sem->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($report)
        <div class="card mt-4">
            <div class="card-header">
                {{ $report['semester']->full_name }} - Attendance Summary
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Total Students</h6>
                                <h3 class="mb-0">{{ $report['total_students'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Total Courses</h6>
                                <h3 class="mb-0">{{ $report['total_courses'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Present</h6>
                                <h3 class="mb-0 text-success">{{ $report['present_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card warning">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Absent</h6>
                                <h3 class="mb-0 text-danger">{{ $report['absent_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                @if($report['total_attendances'] > 0)
                    <div class="mb-3">
                        <h5>Attendance Rate</h5>
                        @php
                            $percentage = round(($report['present_count'] / $report['total_attendances']) * 100, 2);
                        @endphp
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar {{ $percentage >= 75 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $percentage }}% Present
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Detailed Records</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['attendances'] as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>{{ $attendance->student->fullname }} ({{ $attendance->student->student_id }})</td>
                                        <td>{{ $attendance->course->course_name }}</td>
                                        <td>
                                            <span class="badge {{ $attendance->status === 'Present' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $report['attendances']->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        No attendance records found for {{ $report['semester']->full_name }}.
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection