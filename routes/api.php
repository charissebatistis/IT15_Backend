<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/token-test', function () {
    $user = User::first();
    return $user->createToken('test')->plainTextToken;
});

Route::post('/login', [AuthController::class, 'login']);
