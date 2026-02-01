@extends('layouts.app')

@section('title', 'Students - University Attendance System')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-people-fill me-2"></i>Students</h1>
            <p class="text-muted">Manage student records</p>
        </div>
        <div>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Student
            </a>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 gap-2">
        <li class="nav-item">
            <a class="nav-link {{ !request('semester_id') ? 'active' : '' }}" href="{{ route('students.index') }}">All
                Students</a>
        </li>
        @foreach($semesters as $sem)
            <li class="nav-item">
                <a class="nav-link {{ request('semester_id') == $sem->id ? 'active' : '' }}"
                    href="{{ route('students.index', array_merge(request()->all(), ['semester_id' => $sem->id])) }}">
                    {{ $sem->name }} - {{ $sem->group }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-filter me-2"></i>Filter
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}" class="row g-3">
                <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name or Student ID"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Student List ({{ $students->total() }} total)
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Semester</th>
                                <th>Department</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td><strong>{{ $student->student_id }}</strong></td>
                                    <td>{{ $student->fullname }}</td>
                                    <td>
                                        <i
                                            class="bi bi-{{ $student->gender === 'Male' ? 'gender-male text-primary' : 'gender-female text-danger' }}"></i>
                                        {{ $student->gender }}
                                    </td>
                                    <td>
                                        @if($student->semesterInfo)
                                            <span
                                                class="badge bg-soft-primary text-primary px-3 py-2 border border-primary-subtle rounded-pill">
                                                {{ $student->semesterInfo->full_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->department }}</td>
                                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $students->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No students found.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus-fill me-2"></i>Add First Student
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection