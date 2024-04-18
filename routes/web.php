<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Auth\AuthenticationController;

// Public Routes
Route::prefix('api/auth/v1')->group(function() {
    Route::get('signUp', [AuthenticationController::class, 'signUp'])->name('auth.signUp');
    Route::get('signIn', [AuthenticationController::class, 'signIn'])->name('auth.signIn');
    Route::get('signOut', [AuthenticationController::class, 'signOut'])->name('auth.signOut');
});

// Protected Routes
Route::middleware('auth:api')->prefix('api/v1')->group(function () {
    Route::get('getAllUsers', [UserController::class, 'getAllUsers'])->name('user.getAllUsers');
});
