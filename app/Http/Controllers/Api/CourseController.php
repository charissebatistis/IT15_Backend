<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Get all courses
     */
    public function index(Request $request)
    {
        $query = Course::query();

        // Filter by department
        if ($request->has('department')) {
            $query->where('department', $request->department);
        }

        // Search by course code or name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', "%$search%")
                  ->orWhere('course_name', 'like', "%$search%");
            });
        }

        $courses = $query->get();
        return response()->json($courses);
    }

    /**
     * Get a single course with students
     */
    public function show($id)
    {
        $course = Course::with(['students', 'schoolDays'])->findOrFail($id);
        return response()->json($course);
    }

    /**
     * Get courses by department
     */
    public function byDepartment($department)
    {
        $courses = Course::where('department', $department)->get();
        return response()->json($courses);
    }

    /**
     * Get enrollment statistics
     */
    public function enrollmentStats()
    {
        $stats = [
            'total_courses' => Course::count(),
            'by_department' => Course::selectRaw('department, count(*) as total, sum(current_enrollment) as total_enrolled')
                                     ->groupBy('department')
                                     ->get(),
            'courses_with_enrollment' => Course::with('students')
                                               ->get()
                                               ->map(function ($course) {
                                                   return [
                                                       'id' => $course->id,
                                                       'course_name' => $course->course_name,
                                                       'enrollment' => $course->students->count(),
                                                       'capacity' => $course->max_capacity,
                                                       'percentage' => round(($course->students->count() / $course->max_capacity) * 100, 2),
                                                   ];
                                               }),
        ];

        return response()->json($stats);
    }
}
