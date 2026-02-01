@extends('layouts.app')

@section('title', 'Promote Students - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-arrow-up-circle-fill me-2"></i>Promote Students</h1>
        <p class="text-muted">Move students from one semester to another in bulk</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Promotion Action
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>How this works:</strong> Select a source semester and a destination semester. All students
                        from the source will be moved to the destination.
                        Attendance and historical data remain linked to the original semester.
                    </div>

                    <form action="{{ route('promotion.store') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to promote these students? This action moves them permanently to the new semester.');">
                        @csrf

                        <div class="mb-3">
                            <label for="from_semester_id" class="form-label">Promote Students From:</label>
                            <select name="from_semester_id" id="from_semester_id" class="form-select" required>
                                <option value="">Select source semester...</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem->id }}">{{ $sem->full_name }} ({{ $sem->students_count }} students)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="to_semester_id" class="form-label">To Details:</label>
                            <select name="to_semester_id" id="to_semester_id" class="form-select" required>
                                <option value="">Select destination semester...</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem->id }}">{{ $sem->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-arrow-up-circle me-2"></i>Promote Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Current Student Distribution
                </div>
                <div class="card-body">
                    @if($semesters->sum('students_count') > 0)
                        <ul class="list-group">
                            @foreach($semesters as $sem)
                                @if($sem->students_count > 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $sem->name }} - {{ $sem->group }}
                                        <span class="badge bg-primary rounded-pill">{{ $sem->students_count }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">No students found assigned to active semesters.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection