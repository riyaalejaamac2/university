<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Attendance System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            padding: 0;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar .brand {
            padding: 1.5rem 1rem;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .brand h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.875rem 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #5a5c69;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card.info {
            border-left-color: var(--info-color);
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }

        .table {
            color: #5a5c69;
        }

        .table thead th {
            background-color: #f8f9fc;
            border-color: #e3e6f0;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            padding: 0.35rem 0.65rem;
            font-weight: 600;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-mortarboard-fill"></i> University</h4>
            <small>Attendance System</small>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"
                href="{{ route('students.index') }}">
                <i class="bi bi-people-fill"></i> Students
            </a>
            <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                href="{{ route('courses.index') }}">
                <i class="bi bi-book-fill"></i> Courses
            </a>
            <a class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}"
                href="{{ route('attendances.index') }}">
                <i class="bi bi-calendar-check-fill"></i> Attendance
            </a>
            <a class="nav-link {{ request()->routeIs('semesters.*') ? 'active' : '' }}"
                href="{{ route('semesters.index') }}">
                <i class="bi bi-calendar-range"></i> Semesters
            </a>
            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                href="{{ route('settings.index') }}">
                <i class="bi bi-gear-fill"></i> Sitting
            </a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                href="{{ route('reports.index') }}">
                <i class="bi bi-file-earmark-text-fill"></i> Reports
            </a>
            <a class="nav-link {{ request()->routeIs('archives.*') ? 'active' : '' }}"
                href="{{ route('archives.index') }}">
                <i class="bi bi-archive-fill"></i> Archives
            </a>
            <a class="nav-link {{ request()->routeIs('promotion.*') ? 'active' : '' }}"
                href="{{ route('promotion.index') }}">
                <i class="bi bi-arrow-up-circle-fill"></i> Promotion
            </a>
            <hr class="mx-3 my-2" style="border-top: 1px solid rgba(255, 255, 255, 0.15);">
            <a class="nav-link" href="/admin" target="_blank">
                <i class="bi bi-shield-lock-fill"></i> Admin Area
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Academic Year:
                        <strong>{{ $settings->academic_year ?? '2025-2026' }}</strong></span>
                    <span class="mx-2">|</span>
                    <span class="text-muted">Current Semester:
                        <strong>{{ $settings->current_semester ?? '1' }}</strong></span>
                </div>
                <div>
                    <span
                        class="badge {{ ($settings->attendance_status ?? 'Open') === 'Open' ? 'bg-success' : 'bg-danger' }}">
                        Attendance: {{ $settings->attendance_status ?? 'Open' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>