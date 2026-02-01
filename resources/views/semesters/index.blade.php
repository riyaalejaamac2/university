@extends('layouts.app')

@section('title', 'Semesters - University Attendance System')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-calendar-range me-2"></i>Semesters</h1>
        <a href="{{ route('semesters.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add New Semester
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Group</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Students</th>
                            <th>Courses</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semesters as $semester)
                            <tr>
                                <td>{{ $semester->name }}</td>
                                <td><span class="badge bg-secondary">{{ $semester->group }}</span></td>
                                <td>{{ $semester->academic_year }}</td>
                                <td>
                                    @if($semester->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($semester->status == 'Inactive')
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $semester->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $semester->students_count }}</td>
                                <td>{{ $semester->courses_count }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('semesters.show', $semester) }}" class="btn btn-sm btn-outline-info"
                                            title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('semesters.edit', $semester) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('semesters.toggle', $semester) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-{{ $semester->status == 'Active' ? 'warning' : 'success' }}"
                                                title="{{ $semester->status == 'Active' ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi bi-power"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('semesters.destroy', $semester) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this semester?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No semesters found. Create one to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection