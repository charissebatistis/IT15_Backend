<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolDay extends Model
{
    protected $fillable = [
        'course_id',
        'date',
        'day_type',
        'description',
        'attendance_count',
        'total_students',
    ];

    protected $casts = [
        'date' => 'date',
        'attendance_count' => 'integer',
        'total_students' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getAttendancePercentageAttribute()
    {
        if ($this->total_students == 0) {
            return 0;
        }
        return round(($this->attendance_count / $this->total_students) * 100, 2);
    }
}
