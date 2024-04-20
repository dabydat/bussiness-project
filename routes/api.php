<?php

use App\Http\Controllers\APIRequest\ConversionRatesController;
use App\Http\Controllers\Enterprise\ActivitiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Enterprise\EnterpriseController;

// Public Routes
Route::prefix('auth/v1')->group(function() {
    Route::get('signUp', [AuthenticationController::class, 'signUp'])->name('auth.signUp');
    Route::get('signIn', [AuthenticationController::class, 'signIn'])->name('auth.signIn');
    Route::get('signOut', [AuthenticationController::class, 'signOut'])->name('auth.signOut');
});

// Protected Routes
Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('getAllUsers', [UserController::class, 'getAllUsers'])->name('user.getAllUsers');
    Route::get('getEnterpriseUsers', [UserController::class, 'getEnterpriseUsers'])->name('users.getEnterpriseUsers');
    Route::post('changeRole/{user_id}/{action}', [UserController::class, 'changeRole'])->name('user.changeRole');

    Route::get('getAllEnterprises', [EnterpriseController::class, 'getAllEnterprises'])->name('enterprise.getAllEnterprises');
    Route::get('getEnterpriseWithoutActivities', [EnterpriseController::class, 'getEnterpriseWithoutActivities'])->name('enterprise.getEnterpriseWithoutActivities');
    Route::post('createEnterprise', [EnterpriseController::class, 'storeEnterprise'])->name('enterprise.createEnterprise');
    
    Route::get('getAllActivities', [ActivitiesController::class, 'getAllActivities'])->name('activity.getAllActivities');
    Route::post('createActivity', [ActivitiesController::class, 'storeActivity'])->name('activity.createActivity');

    Route::get('getAllEnterpriseActivities', [ActivitiesController::class, 'getAllEnterpriseActivities'])->name('activity.getAllEnterpriseActivities');
    Route::post('createEnterpriseActivity', [ActivitiesController::class, 'storeEnterpriseWithActivity'])->name('activity.createActivity');

    Route::post('getConversionRates', [ConversionRatesController::class, 'getConversionRates'])->name('api.getConversionRates');

});
