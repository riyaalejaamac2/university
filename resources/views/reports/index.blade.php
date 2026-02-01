@extends('layouts.app')

@section('title', 'Reports - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-file-earmark-text-fill me-2"></i>Reports</h1>
        <p class="text-muted">Generate and view attendance reports</p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                    <h5 class="mt-3">Attendance by Semester</h5>
                    <p class="text-muted">View attendance statistics grouped by semester</p>
                    <a href="{{ route('reports.semester') }}" class="btn btn-primary">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-book-fill" style="font-size: 3rem; color: var(--success-color);"></i>
                    <h5 class="mt-3">Attendance by Course</h5>
                    <p class="text-muted">View attendance statistics for specific courses</p>
                    <a href="{{ route('reports.course') }}" class="btn btn-success">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-fill" style="font-size: 3rem; color: var(--info-color);"></i>
                    <h5 class="mt-3">Attendance by Student</h5>
                    <p class="text-muted">View individual student attendance records</p>
                    <a href="{{ route('reports.student') }}" class="btn btn-info">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Report Features
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="bi bi-check-circle-fill text-success me-2"></i>Semester Reports</h6>
                    <p class="text-muted">View overall attendance statistics for each semester including total students,
                        courses, and attendance percentages.</p>
                </div>
                <div class="col-md-4">
                    <h6><i class="bi bi-check-circle-fill text-success me-2"></i>Course Reports</h6>
                    <p class="text-muted">Analyze attendance for specific courses to identify patterns and student
                        participation.</p>
                </div>
                <div class="col-md-4">
                    <h6><i class="bi bi-check-circle-fill text-success me-2"></i>Student Reports</h6>
                    <p class="text-muted">Track individual student attendance across all courses with attendance percentage
                        calculations.</p>
                </div>
            </div>
        </div>
    </div>
@endsection