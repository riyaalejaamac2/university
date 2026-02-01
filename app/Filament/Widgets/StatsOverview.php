<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->description('Active students in system')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Courses', Course::count())
                ->description('Courses offered')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Attendance Rate', $this->getAttendanceRate() . '%')
                ->description('Average daily attendance')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),
            Stat::make('System Users', User::count())
                ->description('Staff accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }

    protected function getAttendanceRate(): float
    {
        $total = Attendance::count();
        if ($total === 0)
            return 0;

        $present = Attendance::where('status', 'Present')->count();
        return round(($present / $total) * 100, 1);
    }
}
