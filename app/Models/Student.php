<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'fullname',
        'gender',
        'semester', // Deprecated but kept for now
        'semester_id',
        'department',
    ];

    public function semesterInfo()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get all attendances for this student
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
