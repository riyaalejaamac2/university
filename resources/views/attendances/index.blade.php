@extends('layouts.app')

@section('title', 'Attendance - University Attendance System')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-calendar-check-fill me-2"></i>Attendance Records</h1>
            <p class="text-muted">View and manage attendance</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('students.create', ['semester_id' => request('semester_id')]) }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus-fill me-2"></i>New Add Student
            </a>
            <a href="{{ route('attendances.create', ['semester_id' => request('semester_id')]) }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle-fill me-2"></i>New / Add Attendance
            </a>
        </div>
    </div>

    <!-- Navigation Tabs for Semesters -->
    <ul class="nav nav-pills mb-4 gap-2 bg-light p-2 rounded-3 shadow-sm overflow-auto flex-nowrap">
        <li class="nav-item">
            <a class="nav-link {{ !request('semester_id') ? 'active px-4' : '' }}" href="{{ route('attendances.index') }}">
                <i class="bi bi-grid-fill me-2"></i>All Semesters
            </a>
        </li>
        @foreach($semesters as $sem)
            <li class="nav-item text-nowrap">
                <a class="nav-link {{ request('semester_id') == $sem->id ? 'active' : '' }}"
                    href="{{ route('attendances.index', array_merge(request()->all(), ['semester_id' => $sem->id])) }}">
                    {{ $sem->full_name }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-filter me-2"></i>Filter Records</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.index') }}" class="row g-3">
                <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">
                <div class="col-md-5">
                    <label class="form-label fw-bold small text-uppercase">Course</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-book"></i></span>
                        <select name="course_id" class="form-select border-start-0">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                @if(!request('semester_id') || $course->semester_id == request('semester_id'))
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }} 
                                        @if(!request('semester_id')) ({{ $course->semesterInfo->name ?? 'N/A' }}) @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-uppercase">Date</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="date" class="form-control border-start-0" value="{{ request('date') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('attendances.index', ['semester_id' => request('semester_id')]) }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Records ({{ $attendances->total() }} total)</h5>
        </div>
        <div class="card-body p-0">
            @if($attendances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Student Information</th>
                                <th>Course</th>
                                <th>Academic Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $attendance->date->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $attendance->date->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $attendance->student->fullname }}</div>
                                        <code class="text-primary smaller">{{ $attendance->student->student_id }}</code>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $attendance->course->course_name }}</div>
                                        <small class="text-muted">{{ $attendance->course->teacher_name }}</small>
                                    </td>
                                    <td>
                                        @if($attendance->semesterInfo)
                                            <span class="badge bg-soft-primary text-primary px-3 py-2 border border-primary-subtle rounded-pill">
                                                {{ $attendance->semesterInfo->full_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $attendance->status === 'Present' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                            {{ $attendance->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this attendance record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $attendances->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted">No attendance records found for this selection.</h5>
                    <a href="{{ route('attendances.create', ['semester_id' => request('semester_id')]) }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle-fill me-2"></i>Record First Attendance
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-soft-primary { background-color: rgba(13, 110, 253, 0.05); }
        .nav-pills .nav-link { color: #6c757d; font-weight: 500; border-radius: 8px; }
        .nav-pills .nav-link.active { background-color: #0d6efd; color: white !important; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2); }
    </style>
@endsection