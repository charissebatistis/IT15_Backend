<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Student;
use App\Models\SchoolDay;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function stats()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => SchoolDay::sum('total_students'),
            'average_attendance' => round(
                SchoolDay::sum('attendance_count') / 
                (SchoolDay::sum('total_students') > 0 ? SchoolDay::sum('total_students') : 1) * 100,
                2
            ),
        ];

        return response()->json($stats);
    }

    /**
     * Get enrollment trend (monthly)
     */
    public function enrollmentTrend()
    {
        $enrollmentData = Student::selectRaw('DATE_FORMAT(enrollment_date, "%Y-%m") as month, count(*) as total')
                                ->whereNotNull('enrollment_date')
                                ->groupByRaw('DATE_FORMAT(enrollment_date, "%Y-%m")')
                                ->orderBy('month')
                                ->get();

        return response()->json([
            'data' => $enrollmentData,
            'labels' => $enrollmentData->pluck('month'),
            'values' => $enrollmentData->pluck('total'),
        ]);
    }

    /**
     * Get course distribution
     */
    public function courseDistribution()
    {
        $distributionData = Student::selectRaw('courses.course_name, count(students.id) as total')
                                  ->join('courses', 'students.course_id', '=', 'courses.id')
                                  ->groupBy('courses.id', 'courses.course_name')
                                  ->get();

        return response()->json([
            'labels' => $distributionData->pluck('course_name'),
            'values' => $distributionData->pluck('total'),
            'data' => $distributionData,
        ]);
    }

    /**
     * Get attendance trend
     */
    public function attendanceTrend()
    {
        $attendanceData = SchoolDay::selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date, 
                                              sum(attendance_count) as attended,
                                              sum(total_students) as total')
                                 ->where('date', '>=', Carbon::now()->subMonths(3))
                                 ->groupByRaw('DATE_FORMAT(date, "%Y-%m-%d")')
                                 ->orderBy('date')
                                 ->limit(90)
                                 ->get()
                                 ->map(function ($item) {
                                     return [
                                         'date' => $item->date,
                                         'percentage' => round(($item->attended / ($item->total > 0 ? $item->total : 1)) * 100, 2),
                                     ];
                                 });

        return response()->json([
            'labels' => $attendanceData->pluck('date'),
            'values' => $attendanceData->pluck('percentage'),
            'data' => $attendanceData,
        ]);
    }

    /**
     * Get department distribution
     */
    public function departmentDistribution()
    {
        $departmentData = Student::selectRaw('courses.department, count(students.id) as total')
                                ->join('courses', 'students.course_id', '=', 'courses.id')
                                ->groupBy('courses.department')
                                ->get();

        return response()->json([
            'labels' => $departmentData->pluck('department'),
            'values' => $departmentData->pluck('total'),
            'data' => $departmentData,
        ]);
    }

    /**
     * Get summary dashboard data
     */
    public function summary()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => SchoolDay::sum('total_students'),
            'average_attendance' => round(
                SchoolDay::sum('attendance_count') / 
                (SchoolDay::sum('total_students') > 0 ? SchoolDay::sum('total_students') : 1) * 100,
                2
            ),
        ];

        $enrollmentData = Student::selectRaw('DATE_FORMAT(enrollment_date, "%Y-%m") as month, count(*) as total')
                                ->whereNotNull('enrollment_date')
                                ->groupByRaw('DATE_FORMAT(enrollment_date, "%Y-%m")')
                                ->orderBy('month')
                                ->get();

        $courseData = Student::selectRaw('courses.course_name, count(students.id) as total')
                                  ->join('courses', 'students.course_id', '=', 'courses.id')
                                  ->groupBy('courses.id', 'courses.course_name')
                                  ->get();

        $attendanceData = SchoolDay::selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date, 
                                              sum(attendance_count) as attended,
                                              sum(total_students) as total')
                                 ->where('date', '>=', Carbon::now()->subMonths(3))
                                 ->groupByRaw('DATE_FORMAT(date, "%Y-%m-%d")')
                                 ->orderBy('date')
                                 ->limit(90)
                                 ->get()
                                 ->map(function ($item) {
                                     return [
                                         'date' => $item->date,
                                         'percentage' => round(($item->attended / ($item->total > 0 ? $item->total : 1)) * 100, 2),
                                     ];
                                 });

        $departmentData = Student::selectRaw('courses.department, count(students.id) as total')
                                ->join('courses', 'students.course_id', '=', 'courses.id')
                                ->groupBy('courses.department')
                                ->get();

        return response()->json([
            'stats' => $stats,
            'enrollment_trend' => [
                'labels' => $enrollmentData->pluck('month'),
                'values' => $enrollmentData->pluck('total'),
                'data' => $enrollmentData,
            ],
            'course_distribution' => [
                'labels' => $courseData->pluck('course_name'),
                'values' => $courseData->pluck('total'),
                'data' => $courseData,
            ],
            'attendance_trend' => [
                'labels' => $attendanceData->pluck('date'),
                'values' => $attendanceData->pluck('percentage'),
                'data' => $attendanceData,
            ],
            'department_distribution' => [
                'labels' => $departmentData->pluck('department'),
                'values' => $departmentData->pluck('total'),
                'data' => $departmentData,
            ],
        ]);
    }
}
