@extends('layouts.app')

@section('title', 'Settings - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-gear-fill me-2"></i>Sitting (Settings)</h1>
        <p class="text-muted">Configure system settings</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    University Configuration
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="university_name" class="form-label">University Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="university_name" id="university_name"
                                class="form-control @error('university_name') is-invalid @enderror"
                                value="{{ old('university_name', $settings->university_name) }}" required>
                            @error('university_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This will be displayed throughout the system</div>
                        </div>

                        <div class="mb-4">
                            <label for="academic_year" class="form-label">Academic Year <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="academic_year" id="academic_year"
                                class="form-control @error('academic_year') is-invalid @enderror"
                                value="{{ old('academic_year', $settings->academic_year) }}" placeholder="2025-2026"
                                required>
                            @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Example: 2025-2026</div>
                        </div>

                        <div class="mb-4">
                            <label for="current_semester" class="form-label">Current Semester <span
                                    class="text-danger">*</span></label>
                            <select name="current_semester" id="current_semester"
                                class="form-select @error('current_semester') is-invalid @enderror" required>
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ old('current_semester', $settings->current_semester) == $i ? 'selected' : '' }}>
                                        Semester {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('current_semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">The currently active semester</div>
                        </div>

                        <div class="mb-4">
                            <label for="attendance_status" class="form-label">Attendance Status <span
                                    class="text-danger">*</span></label>
                            <select name="attendance_status" id="attendance_status"
                                class="form-select @error('attendance_status') is-invalid @enderror" required>
                                <option value="Open" {{ old('attendance_status', $settings->attendance_status) === 'Open' ? 'selected' : '' }}>
                                    Open - Attendance can be recorded
                                </option>
                                <option value="Closed" {{ old('attendance_status', $settings->attendance_status) === 'Closed' ? 'selected' : '' }}>
                                    Closed - Attendance recording is disabled
                                </option>
                            </select>
                            @error('attendance_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Control whether attendance can be recorded</div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Note:</strong> When attendance status is set to "Closed", no attendance records can be
                            created.
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="card mt-4">
                <div class="card-header">
                    System Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Last Updated</h6>
                            <p>{{ $settings->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">System Version</h6>
                            <p>Laravel {{ app()->version() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection