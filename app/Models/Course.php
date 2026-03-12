<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'course_name',
        'department',
        'description',
        'credits',
        'instructor_name',
        'max_capacity',
        'current_enrollment',
    ];

    protected $casts = [
        'credits' => 'integer',
        'max_capacity' => 'integer',
        'current_enrollment' => 'integer',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function schoolDays()
    {
        return $this->hasMany(SchoolDay::class);
    }
}
