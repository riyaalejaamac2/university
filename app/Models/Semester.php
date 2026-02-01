<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $fillable = ['name', 'group', 'academic_year', 'status'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // Helper to get full name like "Semester 1 - Group A"
    public function getFullNameAttribute()
    {
        $groupStr = $this->group === 'None' ? '' : " - Group {$this->group}";
        return "{$this->name}{$groupStr} ({$this->academic_year})";
    }
}
