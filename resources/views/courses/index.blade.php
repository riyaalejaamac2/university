@extends('layouts.app')

@section('title', 'Courses - University Attendance System')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-book-fill me-2"></i>Courses</h1>
            <p class="text-muted">Manage course records</p>
        </div>
        <div>
            <a href="{{ route('courses.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle-fill me-2"></i>Add New Course
            </a>
        </div>
    </div>

    <!-- Navigation Tabs for Semesters -->
    <ul class="nav nav-pills mb-4 gap-2 bg-light p-2 rounded-3 shadow-sm">
        <li class="nav-item">
            <a class="nav-link {{ !request('semester_id') ? 'active px-4' : '' }}" href="{{ route('courses.index') }}">
                <i class="bi bi-grid-fill me-2"></i>All Courses
            </a>
        </li>
        @foreach($semesters as $sem)
            <li class="nav-item text-nowrap">
                <a class="nav-link {{ request('semester_id') == $sem->id ? 'active' : '' }}"
                    href="{{ route('courses.index', array_merge(request()->all(), ['semester_id' => $sem->id])) }}">
                    {{ $sem->full_name }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-filter me-2"></i>Filter Courses</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('courses.index') }}" class="row g-3">
                <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Course Name or Teacher..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm">
                            <i class="bi bi-filter me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Course Registry ({{ $courses->total() }} total)</h5>
        </div>
        <div class="card-body p-0">
            @if($courses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Course Name</th>
                                <th>Assigned Teacher</th>
                                <th>Academic Semester</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold fs-6">{{ $course->course_name }}</div>
                                        <small class="text-muted">{{ \Str::limit($course->description, 60) }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($course->teacher_name, 0, 1)) }}
                                            </div>
                                            <span>{{ $course->teacher_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($course->semesterInfo)
                                            <span
                                                class="badge bg-soft-primary text-primary px-3 py-2 border border-primary-subtle rounded-pill">
                                                <i class="bi bi-calendar3 me-1"></i> {{ $course->semesterInfo->full_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this course?');">
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
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted">No courses found matching criteria.</h5>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle-fill me-2"></i>Add First Course
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .nav-pills .nav-link {
            color: #6c757d;
            font-weight: 500;
            border-radius: 8px;
        }

        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }
    </style>
@endsection