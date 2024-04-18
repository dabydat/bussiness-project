<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'hola';
});

// Public Routes

Route::prefix('auth/v1')->group(function() {
    Route::get('signUp', [AuthenticationController::class, 'signUp'])->name('auth.signUp');
    Route::get('signIn', [AuthenticationController::class, 'signIn'])->name('auth.signIn');
    Route::get('signOut', [AuthenticationController::class, 'signOut'])->name('auth.signOut');
});

Route::middleware('auth:api')->group(function () {
    Route::get('show', [AuthenticationController::class, 'show'])->name('auth.show');
});