@extends('layouts.app')

@section('title', 'Edit Course - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-pencil-fill me-2"></i>Edit Course</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Course Information
                </div>
                <div class="card-body">
                    <form action="{{ route('courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="course_name" id="course_name"
                                class="form-control @error('course_name') is-invalid @enderror"
                                value="{{ old('course_name', $course->course_name) }}" required>
                            @error('course_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teacher_name" class="form-label">Teacher Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="teacher_name" id="teacher_name"
                                class="form-control @error('teacher_name') is-invalid @enderror"
                                value="{{ old('teacher_name', $course->teacher_name) }}" required>
                            @error('teacher_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester_id" id="semester_id"
                                class="form-select @error('semester_id') is-invalid @enderror" required>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem->id }}" {{ old('semester_id', $course->semester_id) == $sem->id ? 'selected' : '' }}>
                                        {{ $sem->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection