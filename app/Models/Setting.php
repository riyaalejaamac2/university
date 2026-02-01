<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'university_name',
        'academic_year',
        'current_semester',
        'attendance_status',
    ];

    /**
     * Get the single settings instance
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'university_name' => 'University Name',
            'academic_year' => '2025-2026',
            'current_semester' => 1,
            'attendance_status' => 'Open',
        ]);
    }
}
