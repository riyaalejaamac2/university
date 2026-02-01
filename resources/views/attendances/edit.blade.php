@extends('layouts.app')

@section('title', 'Edit Attendance - University Attendance System')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('attendances.index') }}">Attendance</a></li>
            <li class="breadcrumb-item active">Edit Record</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Edit Attendance Record
                </div>
                <div class="card-body">
                    <form action="{{ route('attendances.update', $attendance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control"
                                value="{{ $attendance->student->fullname }} ({{ $attendance->student->student_id }})"
                                readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <input type="text" class="form-control" value="{{ $attendance->course->course_name }}" readonly
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="text" class="form-control" value="{{ $attendance->date->format('F d, Y') }}"
                                readonly disabled>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="present" value="Present"
                                        {{ $attendance->status == 'Present' ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-bold" for="present">
                                        Present
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="absent" value="Absent" {{ $attendance->status == 'Absent' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-bold" for="absent">
                                        Absent
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection