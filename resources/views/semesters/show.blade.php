@extends('layouts.app')

@section('title', $semester->full_name . ' - University Attendance System')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-calendar3 me-2"></i>{{ $semester->full_name }}</h1>
            <p class="text-muted">Detailed view of semester students and courses</p>
        </div>
        <div>
            <a href="{{ route('semesters.edit', $semester) }}" class="btn btn-warning shadow-sm me-2">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">
                        {{ $semester->students_count ?? $semester->students()->count() }}</div>
                    <div class="text-muted text-uppercase fw-bold small">Enrolled Students</div>
                    <hr>
                    <div class="bg-light p-3 rounded-3 text-start">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Status:</span>
                            <span class="badge {{ $semester->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $semester->status }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Acd. Year:</span>
                            <span class="fw-bold">{{ $semester->academic_year }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Group:</span>
                            <span class="badge bg-info text-dark">{{ $semester->group }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-book-half me-2"></i>Assigned Courses</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Course Name</th>
                                    <th>Teacher</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $course->course_name }}</td>
                                        <td>{{ $course->teacher_name }}</td>
                                        <td>
                                            <a href="{{ route('courses.edit', $course) }}"
                                                class="btn btn-sm btn-outline-primary">View / Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No courses assigned to this
                                            semester.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people-fill me-2"></i>Student Distribution ({{ $students->total() }})
            </h5>
            <a href="{{ route('students.create', ['semester_id' => $semester->id]) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i>Add Student
            </a>
        </div>
        <div class="card-body p-0">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="ps-3"><code>{{ $student->student_id }}</code></td>
                                    <td class="fw-semibold">{{ $student->fullname }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $student->department }}</span></td>
                                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $students->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No students enrolled in this semester yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection