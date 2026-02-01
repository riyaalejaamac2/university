<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'semester', // Deprecated
        'semester_id',
        'academic_year',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function semesterInfo()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    } // Overwrites the 'semester' attribute access potentially? No, relation wins if called as method. But semester column is integer.
    // Ideally I should rename the column, but for now I will rely on relation ->semester() vs attribute ->semester.
    // Actually, conflicts might happen. I'll call relation semesterModel() just in case, but standard Laravel is semester().


    /**
     * Get the student for this attendance
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course for this attendance
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
