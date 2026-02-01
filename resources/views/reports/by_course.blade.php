@extends('layouts.app')

@section('title', 'Attendance Report by Course - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-book-fill me-2"></i>Attendance Report by Course</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">By Course</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            Select Course
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.course') }}" class="row g-3">
                <div class="col-md-8">
                    <label for="course_id" class="form-label">Course</label>
                    <select name="course_id" id="course_id" class="form-select" required>
                        <option value="">Choose Course...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $courseId == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }} - {{ $course->teacher_name }}
                                ({{ $course->semesterInfo ? $course->semesterInfo->full_name : 'Sem ' . $course->semester }})
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
                Course: {{ $report['course']->course_name }}
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Teacher</h6>
                        <p>{{ $report['course']->teacher_name }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Semester</h6>
                        <p>
                            @if($report['course']->semesterInfo)
                                <span class="badge bg-primary">{{ $report['course']->semesterInfo->full_name }}</span>
                            @else
                                <span class="badge bg-secondary">Semester {{ $report['course']->semester }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Total Records</h6>
                        <p><strong>{{ $report['total_records'] }}</strong></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Present</h6>
                                <h3 class="mb-0 text-success">{{ $report['present_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card stat-card warning">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.75rem;">Absent</h6>
                                <h3 class="mb-0 text-danger">{{ $report['absent_count'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                @if($report['total_records'] > 0)
                    @php
                        $percentage = round(($report['present_count'] / $report['total_records']) * 100, 2);
                    @endphp
                    <div class="mb-4">
                        <h5>Course Attendance Rate</h5>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar {{ $percentage >= 75 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $percentage }}% Present
                            </div>
                        </div>
                    </div>

                    <h5>Attendance Records</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['attendances'] as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>{{ $attendance->student->fullname }}</td>
                                        <td>{{ $attendance->student->student_id }}</td>
                                        <td>{{ $attendance->student->department }}</td>
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
                        No attendance records found for this course.
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection