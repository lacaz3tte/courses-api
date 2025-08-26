<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:global')->group(function (){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/courses', [CourseController::class, 'index']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::resource('/applications', ApplicationController::class)->only(
            ['index', 'store', 'show', 'destroy']
        );

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});
