@extends('layouts.app')

@section('title', 'Edit Semester - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-pencil-fill me-2"></i>Edit Semester</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('semesters.index') }}">Semesters</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Semester Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('semesters.update', $semester) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Semester Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $semester->name) }}" required placeholder="e.g. Semester 1">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="academic_year" class="form-label fw-bold">Academic Year <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="academic_year" id="academic_year"
                                    class="form-control @error('academic_year') is-invalid @enderror"
                                    value="{{ old('academic_year', $semester->academic_year) }}" required
                                    placeholder="e.g. 2025-2026">
                                @error('academic_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Group <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4 p-3 bg-light rounded-3 border">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="group_none" value="None"
                                        {{ old('group', $semester->group) === 'None' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="group_none">None (General)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="group_a" value="A" {{ old('group', $semester->group) === 'A' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="group_a">Group A</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="group_b" value="B" {{ old('group', $semester->group) === 'B' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="group_b">Group B</label>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Choose "None" if this semester does not have split
                                groups.</small>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="Active" {{ old('status', $semester->status) === 'Active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="Inactive" {{ old('status', $semester->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <small class="text-muted mt-1 d-block">Inactive semesters won't show in new attendance
                                markings.</small>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top mt-4">
                            <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="bi bi-cloud-check me-2"></i>Update Semester
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection