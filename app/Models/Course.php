<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'teacher_name',
        'semester', // Deprecated
        'semester_id',
        'description',
    ];

    public function semesterInfo()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get all attendances for this course
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
