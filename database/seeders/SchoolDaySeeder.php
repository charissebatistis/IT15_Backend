<?php

namespace Database\Seeders;

use App\Models\SchoolDay;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SchoolDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        $dayTypes = ['Regular', 'Holiday', 'Event', 'Exam'];
        
        // Create school days for the last 6 months
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        foreach ($courses as $course) {
            $currentDate = $startDate->copy();
            
            while ($currentDate <= $endDate) {
                // Skip weekends (Saturday = 6, Sunday = 0)
                if ($currentDate->dayOfWeek === 0 || $currentDate->dayOfWeek === 6) {
                    $currentDate->addDay();
                    continue;
                }

                $dayType = 'Regular';
                if ($currentDate->day === 1 || $currentDate->day === 25) {
                    $dayType = 'Holiday';
                } elseif ($currentDate->format('w') === '3') { // Wednesday
                    $dayType = 'Event';
                } elseif ($currentDate->format('d') % 15 === 0) { // Every 15th
                    $dayType = 'Exam';
                }

                $schoolDay = SchoolDay::create([
                    'course_id' => $course->id,
                    'date' => $currentDate->copy(),
                    'day_type' => $dayType,
                    'description' => 'School day for ' . $course->course_name,
                ]);

                // Create attendance records
                $students = Student::where('course_id', $course->id)->get();
                $schoolDay->update([
                    'total_students' => $students->count(),
                    'attendance_count' => 0
                ]);

                foreach ($students as $student) {
                    $attendanceStatus = 'Absent';
                    $random = rand(0, 100);

                    if ($random < 85) { // 85% present
                        $attendanceStatus = 'Present';
                        $schoolDay->increment('attendance_count');
                    } elseif ($random < 92) { // 7% late
                        $attendanceStatus = 'Late';
                        $schoolDay->increment('attendance_count');
                    } elseif ($random < 98) { // 6% excused
                        $attendanceStatus = 'Excused';
                    }

                    Attendance::create([
                        'student_id' => $student->id,
                        'school_day_id' => $schoolDay->id,
                        'status' => $attendanceStatus,
                    ]);
                }

                $currentDate->addDay();
            }
        }
    }
}
