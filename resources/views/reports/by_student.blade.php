@extends('layouts.app')

@section('title', 'Attendance Report by Student - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-person-fill me-2"></i>Attendance Report by Student</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">By Student</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            Select Student
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.student') }}" class="row g-3">
                <div class="col-md-8">
                    <label for="student_id" class="form-label">Student</label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        <option value="">Choose Student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $studentId == $student->id ? 'selected' : '' }}>
                                {{ $student->fullname }} ({{ $student->student_id }}) -
                                {{ $student->semesterInfo ? $student->semesterInfo->full_name : 'Sem ' . $student->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
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
                Student: {{ $report['student']->fullname }}
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <h6 class="text-muted">Student ID</h6>
                        <p><strong>{{ $report['student']->student_id }}</strong></p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Gender</h6>
                        <p>{{ $report['student']->gender }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Semester</h6>
                        <p>
                            @if($report['student']->semesterInfo)
                                <span class="badge bg-primary">{{ $report['student']->semesterInfo->full_name }}</span>
                            @else
                                <span class="badge bg-secondary">Semester {{ $report['student']->semester }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Department</h6>
                        <p>{{ $report['student']->department }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Total Records</h6>
                                <h3 class="mb-0">{{ $report['total_records'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Present</h6>
                                <h3 class="mb-0 text-success">{{ $report['present_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card warning">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Absent</h6>
                                <h3 class="mb-0 text-danger">{{ $report['absent_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                @if($report['total_records'] > 0)
                    <div class="mb-4">
                        <h5>Attendance Percentage</h5>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar {{ $report['attendance_percentage'] >= 75 ? 'bg-success' : ($report['attendance_percentage'] >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                role="progressbar" style="width: {{ $report['attendance_percentage'] }}%;"
                                aria-valuenow="{{ $report['attendance_percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $report['attendance_percentage'] }}% Present
                            </div>
                        </div>
                        @if($report['attendance_percentage'] < 75)
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Warning:</strong> Attendance percentage is below 75%. This student may need additional support.
                            </div>
                        @endif
                    </div>

                    <h5>Attendance History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Course</th>
                                    <th>Teacher</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['attendances'] as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>{{ $attendance->course->course_name }}</td>
                                        <td>{{ $attendance->course->teacher_name }}</td>
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
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        No attendance records found for this student.
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection