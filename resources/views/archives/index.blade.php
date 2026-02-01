@extends('layouts.app')

@section('title', 'Archives - University Attendance System')

@section('content')
    <div class="page-header">
        <h1><i class="bi bi-archive-fill me-2 text-primary"></i>Archives & Absence Tracking</h1>
        <p class="text-muted">Analyze historical attendance and track student absence patterns.</p>
    </div>

    <div class="row g-4">
        <!-- Search Filters -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-search me-2"></i>Filter Archives</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('archives.index') }}">
                        <div class="mb-3">
                            <label for="academic_year" class="form-label small fw-bold text-uppercase">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-select border-start-0 bg-light border-0 shadow-none" style="border-left: 4px solid #0d6efd !important;">
                                <option value="">Select Year...</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester_id" class="form-label small fw-bold text-uppercase">Semester</label>
                            <select name="semester_id" id="semester_id" class="form-select border-start-0 bg-light border-0 shadow-none" style="border-left: 4px solid #0d6efd !important;">
                                <option value="">Select Semester...</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem->id }}" {{ $selectedSemesterId == $sem->id ? 'selected' : '' }}>
                                        {{ $sem->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                            <i class="bi bi-filter-square me-2"></i>Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 text-success">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge-fill me-2"></i>Student History</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('archives.index') }}">
                        <div class="mb-3">
                            <label for="student_search" class="form-label small fw-bold text-uppercase text-success">Quick Lookup</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="student_search" id="student_search" class="form-control bg-light border-0 shadow-none"
                                    placeholder="Enter Student ID or Name" value="{{ $searchStudent }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                            <i class="bi bi-person-video2 me-2"></i>View History
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-8">
            <!-- Student History Section -->
            @if($selectedStudent && $studentHistory)
                <div class="card border-0 shadow-sm mb-4 border-start border-success border-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-clock-history me-2"></i>Academic History: {{ $selectedStudent->fullname }}</h5>
                        <span class="badge bg-success px-3 py-2">ID: {{ $selectedStudent->student_id }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Academic Semester</th>
                                        <th class="text-center">Total Classes</th>
                                        <th class="text-center">Absences</th>
                                        <th class="text-center">Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($studentHistory as $history)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $history->semesterInfo->full_name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $history->academic_year }}</small>
                                            </td>
                                            <td class="text-center">{{ $history->total_days }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold">
                                                    {{ $history->absent_days }} Days
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $rate = $history->total_days > 0 ? round(($history->present_days / $history->total_days) * 100, 1) : 0;
                                                    $colorClass = $rate >= 75 ? 'text-success' : 'text-danger';
                                                @endphp
                                                <span class="fw-bold {{ $colorClass }}">{{ $rate }}%</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-4">No historical records found for this student.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif($searchStudent)
                <div class="alert alert-warning border-0 shadow-sm"><i class="bi bi-exclamation-triangle me-2"></i>No student found matching "{{ $searchStudent }}"</div>
            @endif

            <!-- Semester Absence Registry -->
            @if($studentStats)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-table me-2"></i>Absence Registry ({{ $selectedYear }} - {{ $studentStats->count() }} Students)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Student</th>
                                        <th class="text-center">Total Absences</th>
                                        @php
                                            // Show month headers (simplified to numeric for alignment, or we can use keys from stats)
                                            $monthsFound = [];
                                            foreach($studentStats as $s) if($s->monthly_absences) $monthsFound = array_unique(array_merge($monthsFound, array_keys($s->monthly_absences->toArray())));
                                            sort($monthsFound);
                                        @endphp
                                        @foreach($monthsFound as $m)
                                            <th class="text-center">{{ \Carbon\Carbon::create()->month((int)$m)->format('M') }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentStats as $stat)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $stat->student->fullname }}</div>
                                                <small class="text-muted">ID: {{ $stat->student->student_id }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $stat->total_absences > 5 ? 'bg-danger' : 'bg-warning text-dark' }} px-3 py-2 rounded-pill">
                                                    {{ $stat->total_absences }} Absences
                                                </span>
                                            </td>
                                            @foreach($monthsFound as $m)
                                                <td class="text-center text-muted">
                                                    {{ $stat->monthly_absences[$m] ?? '-' }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $studentStats->links() }}
                        </div>
                    </div>
                </div>
            @elseif($selectedYear && $selectedSemesterId)
                <div class="alert alert-info border-0 shadow-sm"><i class="bi bi-info-circle me-2"></i>No attendance records found for this semester.</div>
            @endif

            @if(!$studentStats && !$selectedStudent)
                <div class="text-center py-5 bg-white rounded-3 shadow-sm border">
                    <div class="mb-4"><i class="bi bi-folder2-open text-muted" style="font-size: 5rem;"></i></div>
                    <h4 class="text-muted">Select a Semester or Search for a Student</h4>
                    <p class="text-muted px-5">Use the sidebar filters to view student absence logs or historical academic performance data.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
        .table > thead { border-top: 0; }
        .form-select, .form-control { border: 1px solid #e9ecef; }
        .card-header { border-bottom: 1px solid #f8f9fa; }
    </style>
@endsection