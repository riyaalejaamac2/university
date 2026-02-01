@extends('layouts.app')

@section('title', 'Add New Semester - University Attendance System')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('semesters.index') }}">Semesters</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create New Semester</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('semesters.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Semester Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Semester 1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Group</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="groupNone" value="None"
                                        checked>
                                    <label class="form-check-label" for="groupNone">None</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="groupA" value="A">
                                    <label class="form-check-label" for="groupA">Group A</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="groupB" value="B">
                                    <label class="form-check-label" for="groupB">Group B</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <input type="text" name="academic_year" id="academic_year" class="form-control"
                                placeholder="e.g. 2025-2026" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('semesters.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Semester</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection