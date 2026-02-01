@extends('layouts.app')

@section('title', 'Add Student - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-person-plus-fill me-2"></i>Add New Student</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Student Information
                </div>
                <div class="card-body">
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" id="student_id"
                                class="form-control @error('student_id') is-invalid @enderror"
                                value="{{ old('student_id') }}" required>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" id="fullname"
                                class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}"
                                required>
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror"
                                required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester_id" id="semester_id"
                                class="form-select @error('semester_id') is-invalid @enderror" required>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <input type="text" name="department" id="department"
                                class="form-control @error('department') is-invalid @enderror"
                                value="{{ old('department') }}" required>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">e.g., Computer Science, Engineering, Medicine</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection