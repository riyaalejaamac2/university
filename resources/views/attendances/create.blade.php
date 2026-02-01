@extends('layouts.app')

@section('title', 'New Attendance - University Attendance System')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="bi bi-calendar-check-fill me-2"></i>New / Add Attendance</h1>
            <a href="{{ route('students.create', ['semester_id' => request('semester_id')]) }}"
                class="btn btn-outline-primary btn-sm">
                <i class="bi bi-person-plus-fill me-2"></i>New Add Attendance (Students)
            </a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('attendances.index') }}">Attendance</a></li>
                <li class="breadcrumb-item active">New / Add Attendance</li>
            </ol>
        </nav>
    </div>

    <!-- Step 1: Select Course -->
    @if(!$courseId)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><span class="badge bg-primary me-2">Step 1</span> Select Course</h5>
                @if(request('semester_id'))
                    @php $lockedSem = $allSemesters->find(request('semester_id')); @endphp
                    @if($lockedSem)
                        <span class="badge bg-soft-primary text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                            <i class="bi bi-calendar3 me-1"></i> {{ $lockedSem->full_name }}
                        </span>
                    @endif
                @endif
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('attendances.create') }}">
                    @if(request('semester_id'))
                        <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">
                    @endif
                    <div class="row align-items-end g-3">
                        <div class="col-md-8">
                            <label for="course_id" class="form-label fw-semibold">Choose Course To Mark Attendance <span
                                    class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg" required>
                                <option value="">Select a course...</option>
                                @foreach($allCourses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->course_name }} @if(!request('semester_id'))
                                        ({{ $course->semesterInfo->name ?? 'N/A' }}) @endif - {{ $course->teacher_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-check2-circle me-2"></i>Select Course
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @elseif(!$semesterId)
        <!-- Step 2: Select Semester -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><span class="badge bg-primary me-2">Step 2</span> Select Semester</h5>
                <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-link text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Back to Courses
                </a>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-light border mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Selected
                                Course</small>
                            <span class="fs-5 fw-bold">{{ $selectedCourse->course_name }}</span>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Teacher</small>
                            <span class="fs-5">{{ $selectedCourse->teacher_name }}</span>
                        </div>
                    </div>
                </div>

                <form method="GET" action="{{ route('attendances.create') }}">
                    <input type="hidden" name="course_id" value="{{ $courseId }}">
                    <div class="row align-items-end g-3">
                        <div class="col-md-5">
                            <label for="semester_id" class="form-label fw-semibold">Choose Semester <span
                                    class="text-danger">*</span></label>
                            <select name="semester_id" id="semester_id" class="form-select" required>
                                <option value="">Select semester...</option>
                                @foreach($allSemesters as $sem)
                                    @if(!request('semester_id') || $sem->id == request('semester_id'))
                                        <option value="{{ $sem->id }}" {{ $semesterId == $sem->id ? 'selected' : '' }}>
                                            {{ $sem->full_name }}
                                            @if($selectedCourse->semester_id == $sem->id) (Recommended) @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Attendance Date</label>
                            <input type="text" class="form-control bg-light" value="{{ now()->format('F d, Y') }}" readonly>
                            <div class="form-text mt-1 text-success"><i class="bi bi-info-circle me-1"></i>Date is filled
                                automatically</div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-people-fill me-2"></i>Show Students
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Step 3: Mark Attendance -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-success fw-bold"><span class="badge bg-success me-2 text-white">Step 3</span> Mark
                    Attendance</h5>
                <div>
                    @if(!request('semester_id'))
                        <a href="{{ route('attendances.create', ['course_id' => $courseId]) }}"
                            class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-calendar-range me-1"></i>Change Semester
                        </a>
                    @endif
                    <a href="{{ route('attendances.create', ['semester_id' => request('semester_id')]) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-book me-1"></i>Change Course
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body py-2 px-3">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block text-uppercase fw-bold"
                                    style="font-size: 0.65rem;">Course</small>
                                <span class="fw-bold">{{ $selectedCourse->course_name }}</span>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block text-uppercase fw-bold"
                                    style="font-size: 0.65rem;">Semester</small>
                                @php $currentSem = $allSemesters->find($semesterId); @endphp
                                <span class="fw-bold text-primary">{{ $currentSem ? $currentSem->full_name : 'Unknown' }}</span>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <small class="text-muted d-block text-uppercase fw-bold"
                                    style="font-size: 0.65rem;">Date</small>
                                <span class="fw-bold fs-5">{{ now()->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($students->count() === 0)
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-people-fill text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5>No students found in this semester.</h5>
                        <p class="text-muted">Please add students to this semester before marking attendance.</p>
                        <a href="{{ route('students.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-person-plus-fill me-2"></i>Add Student Now
                        </a>
                    </div>
                @else
                    <form action="{{ route('attendances.store') }}" method="POST" id="attendanceForm">
                        @csrf
                        <input type="hidden" name="semester_id" value="{{ $semesterId }}">
                        <input type="hidden" name="course_id" value="{{ $courseId }}">

                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Student ID</th>
                                        <th>Full Name</th>
                                        <th>Department</th>
                                        <th class="text-center" width="200">
                                            Status
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-xs btn-success py-0 px-2"
                                                    style="font-size: 0.7rem;" onclick="markAll('Present')">All P</button>
                                                <button type="button" class="btn btn-xs btn-danger py-0 px-2"
                                                    style="font-size: 0.7rem;" onclick="markAll('Absent')">All A</button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><code class="fw-bold text-dark">{{ $student->student_id }}</code></td>
                                            <td class="fw-semibold">{{ $student->fullname }}</td>
                                            <td><span class="badge bg-light text-dark border">{{ $student->department }}</span></td>
                                            <td>
                                                <input type="hidden" name="attendances[{{ $index }}][student_id]"
                                                    value="{{ $student->id }}">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <div class="form-check form-check-inline p-0 m-0">
                                                        <input type="radio" class="btn-check" name="attendances[{{ $index }}][status]"
                                                            id="present_{{ $student->id }}" value="Present" checked>
                                                        <label class="btn btn-outline-success px-3 btn-sm"
                                                            for="present_{{ $student->id }}">
                                                            <i class="bi bi-check-circle me-1"></i>Present
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline p-0 m-0">
                                                        <input type="radio" class="btn-check" name="attendances[{{ $index }}][status]"
                                                            id="absent_{{ $student->id }}" value="Absent">
                                                        <label class="btn btn-outline-danger px-3 btn-sm"
                                                            for="absent_{{ $student->id }}">
                                                            <i class="bi bi-x-circle me-1"></i>Absent
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white py-3 border-0 px-0 d-flex justify-content-between align-items-center">
                            <a href="{{ route('attendances.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="bi bi-x-circle me-1"></i>Discard and Go Back
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                <i class="bi bi-cloud-check me-2"></i>Save Attendance Records
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function markAll(status) {
            const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
            radios.forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
    <style>
        .btn-xs {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>
@endpush