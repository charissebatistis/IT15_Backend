<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Get all students with optional filtering
     */
    public function index(Request $request)
    {
        $query = Student::with('course');

        // Filter by course
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by year level
        if ($request->has('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Pagination
        $per_page = $request->get('per_page', 15);
        $students = $query->paginate($per_page);

        return response()->json($students);
    }

    /**
     * Get a single student with attendance
     */
    public function show($id)
    {
        $student = Student::with(['course', 'attendances.schoolDay'])->findOrFail($id);
        return response()->json($student);
    }

    /**
     * Get students by course
     */
    public function byCourse($courseId)
    {
        $students = Student::where('course_id', $courseId)
                          ->with('course')
                          ->get();
        return response()->json($students);
    }

    /**
     * Get student statistics
     */
    public function statistics()
    {
        $stats = [
            'total_students' => Student::count(),
            'by_course' => Student::groupBy('course_id')
                                 ->selectRaw('course_id, count(*) as total')
                                 ->with('course:id,course_name')
                                 ->get(),
            'by_year_level' => Student::groupBy('year_level')
                                      ->selectRaw('year_level, count(*) as total')
                                      ->get(),
            'by_gender' => Student::groupBy('gender')
                                  ->selectRaw('gender, count(*) as total')
                                  ->get(),
        ];

        return response()->json($stats);
    }
}
