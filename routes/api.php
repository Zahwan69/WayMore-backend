<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;

// --- Authentication (staff) ---
// Public: anyone can attempt to log in.
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Protected: require a valid Sanctum token (Authorization: Bearer <token>).
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});

// --- User management (superadmin only) ---
// auth:sanctum = must be logged in; superadmin = must have role 'superadmin'.
Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
});

// --- Resources ---
// Passing a singular string to ->names() sets the route-name prefix, so these
// become category.index/store/show/update/destroy (and service.* likewise).
Route::apiResource('categories', CategoryController::class)->names('category');
Route::apiResource('services', ServiceController::class)->names('service');


