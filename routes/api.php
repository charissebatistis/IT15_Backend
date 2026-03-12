<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Public endpoints
Route::get('/token-test', function () {
    $user = User::first();
    return $user->createToken('test')->plainTextToken;
});

Route::post('/login', [AuthController::class, 'login']);

// Protected routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getCurrentUser']);

    // Student routes
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::get('/students/course/{courseId}', [StudentController::class, 'byCourse']);
    Route::get('/students-stats', [StudentController::class, 'statistics']);

    // Course routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/courses/department/{department}', [CourseController::class, 'byDepartment']);
    Route::get('/courses-stats', [CourseController::class, 'enrollmentStats']);

    // Dashboard routes
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/enrollment-trend', [DashboardController::class, 'enrollmentTrend']);
    Route::get('/dashboard/course-distribution', [DashboardController::class, 'courseDistribution']);
    Route::get('/dashboard/attendance-trend', [DashboardController::class, 'attendanceTrend']);
    Route::get('/dashboard/department-distribution', [DashboardController::class, 'departmentDistribution']);
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
});
